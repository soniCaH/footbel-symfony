<?php

namespace KevinVR\FootbalistoProcessorBundle\Processor;

/**
 * Parses an RFC 4180 style CSV file.
 *
 * http://tools.ietf.org/html/rfc4180
 */
class CSVIterator implements \Iterator
{

    /**
     * The column delimeter.
     *
     * @var string
     */
    protected $delimiter = ';';

    /**
     * Whether or not the first line contains a header.
     *
     * @var bool
     */
    protected $hasHeader = false;

    /**
     * The position in the file to start from.
     *
     * @var int
     */
    protected $startByte = 0;

    /**
     * The file handle to the CSV file.
     *
     * @var resource
     */
    protected $handle;

    /**
     * The current line.
     *
     * @var array|bool
     */
    protected $currentLine;

    /**
     * The number of lines read.
     *
     * @var int
     */
    protected $linesRead = 0;

    /**
     * The byte position in the file.
     *
     * @var int
     */
    protected $filePosition;

    /**
     * Constructs a CsvParser object.
     *
     * @param resource $handle
     *   An open file handle.
     */
    public function __construct($handle)
    {
        if (!is_resource($handle)) {
            throw new \InvalidArgumentException('handle must be a resource.');
        }
        $this->handle = $handle;
    }

    /**
     * Creates a CsvParser object from a file path.
     *
     * @param string $filepath
     *   The file path.
     */
    public static function createFromFilePath($filepath)
    {
        if (!file_exists($filepath)) {
            throw new \InvalidArgumentException(
                'Filepath '.$filepath.' must exist.'
            );
        }

        if (!is_readable($filepath)) {
            throw new \InvalidArgumentException(
                'Filepath '.$filepath.' must be readable.'
            );
        }

        $previous = ini_set('auto_detect_line_endings', '1');
        $handle = fopen($filepath, 'r');
        ini_set('auto_detect_line_endings', $previous);

        return new static($handle);
    }

    /**
     * Destructs a CsvParser object,
     */
    public function __destruct()
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }

    /**
     * Sets the column delimiter string.
     *
     * @param string $delimiter
     *   By default, the comma (',') is used as delimiter.
     *
     * @return $this
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * Sets whether or not the CSV file contains a header.
     *
     * @param bool $has_header
     *   (optional) Whether or the CSV file has a header. Defaults to true.
     *
     * @return $this
     */
    public function setHasHeader($has_header = true)
    {
        $this->hasHeader = (bool)$has_header;

        return $this;
    }

    /**
     * Returns the header row.
     *
     * @return array
     *   A list of the header names.
     */
    public function getHeader()
    {
        $prev = ftell($this->handle);

        fseek($this->handle, 0);
        $header = $this->parseLine($this->readLine());
        fseek($this->handle, $prev);

        return $header;
    }

    /**
     * Gets the byte number where the parser left off.
     *
     * This position can be used to set the start byte for the next iteration.
     *
     * @return int
     *   The byte position of where parsing ended.
     */
    public function lastLinePos()
    {
        return $this->filePosition;
    }

    /**
     * Sets the byte where file should be started at.
     *
     * Useful when parsing a file in batches.
     *
     * @param int $start
     *   The byte position to start parsing.
     *
     * @return $this
     */
    public function setStartByte($start)
    {
        $this->startByte = (int)$start;

        return $this;
    }

    /**
     * Implements \Iterator::current().
     */
    public function current()
    {
        return $this->currentLine;
    }

    /**
     * Implements \Iterator::key().
     */
    public function key()
    {
        return $this->linesRead - 1;
    }

    /**
     * Implements \Iterator::next().
     */
    public function next()
    {
// Record the file position before reading the next line since we
// preemptively read lines to avoid returning empty rows.
        $this->filePosition = ftell($this->handle);

        do {
            $line = $this->readLine();

// End of file.
            if ($line === false) {
                $this->currentLine = false;

                return;
            }

// Skip empty lines that aren't wrapped in an enclosure.
        } while (!strlen(rtrim($line, "\r\n")));

        $this->currentLine = $this->parseLine($line);
        $this->linesRead++;
    }

    /**
     * Implements \Iterator::rewind().
     */
    public function rewind()
    {
        fseek($this->handle, 0);

        if ($this->hasHeader && !$this->startByte) {
            $this->parseLine($this->readLine());
        } elseif ($this->startByte) {
            fseek($this->handle, $this->startByte);
        }

        $this->linesRead = 0;
// Preemptively advance to the next line.
        $this->next();
    }

    /**
     * Implements \Iterator::valid().
     */
    public function valid()
    {
        return (bool)$this->currentLine;
    }

    /**
     * Returns a new line from the CSV file.
     *
     * @return string|bool
     *   Returns the next line in the file, or false if the end has been reached.
     *
     * @todo Add encoding conversion.
     */
    protected function readLine()
    {
        return fgets($this->handle);
    }

    /**
     * Parses a single CSV line.
     *
     * @param string $line
     *   A line from a CSV file.
     * @param bool $in_quotes
     *   Do not use. For recursion only.
     * @param string $field
     *   Do not use. For recursion only.
     * @param array $fields
     *   Do not use. For recursion only.
     *
     * @return array
     *   The list of cells in the CSV row.
     */
    protected function parseLine(
        $line,
        $in_quotes = false,
        $field = '',
        $fields = []
    ) {
        $line_length = strlen($line);

// Traverse the line byte-by-byte.
        for ($index = 0; $index < $line_length; $index++) {
            $byte = $line[$index];
            $next_byte = isset($line[$index + 1]) ? $line[$index + 1] : '';

// Found an escaped double quote.
            if ($byte === '"' && $next_byte === '"') {
                $field .= '"';
// Skip the next quote.
                $index++;
            } // Beginning or ending a quoted field.
            elseif ($byte === '"' && $next_byte !== '"') {
                $in_quotes = !$in_quotes;
            } // Ending a field.
            elseif (!$in_quotes && $byte === $this->delimiter) {
                $fields[] = $field;
                $field = '';
            } // End of this line.
            elseif (!$in_quotes && $next_byte === '') {
// Don't save the last newline, but don't use trim to remove all
// newlines.
                if ($byte === "\n") {
// Check for windows line ending.
                    $field = substr($field, -1) === "\r" ? substr(
                        $field,
                        0,
                        -1
                    ) : $field;
                } elseif ($byte === "\r") {
// Mac line endings.
                } else {
// Line ended without a trailing newline.
                    $field .= $byte;
                }

                $fields[] = $field;
                $field = '';
            } else {
                $field .= $byte;
            }
        }

// If we're still in quotes after the line is read continue reading on the
// next line. Check that we're not at the end of a malformed file.
        if ($in_quotes && $line = $this->readLine()) {
            $fields = $this->parseLine($line, $in_quotes, $field, $fields);
        }

        return $fields;
    }

}