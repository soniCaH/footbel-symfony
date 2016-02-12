<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

use Doctrine\ORM\EntityManager;
use KevinVR\FootbelBackendBundle\Entity\ResourceInterface;

/**
 * Class ResourceFileProcessor
 * @package KevinVR\FootbelProcessorBundle\Processor
 */
class ResourceFileProcessor implements ResourceFileProcessorInterface
{
    /**
     * @var \KevinVR\FootbelBackendBundle\Entity\ResourceInterface
     */
    private $resource;

    /**
     * @var \KevinVR\FootbelProcessorBundle\Processor\ResourceQueueWorkerInterface
     */
    private $queueworker;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var string
     */
    private $archivePath;

    /**
     * ResourceFileProcessor constructor.
     * @param \KevinVR\FootbelBackendBundle\Entity\ResourceInterface $resource
     * @param \KevinVR\FootbelProcessorBundle\Processor\ResourceQueueWorkerInterface $queueworker
     */
    public function __construct(ResourceInterface $resource, ResourceQueueWorkerInterface $queueworker, EntityManager $em)
    {
        $this->resource = $resource;
        $this->queueworker = $queueworker;
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     */
    public function process()
    {
//        if (!$this->isMD5HashSame()) {
            $csvFile = $this->extract();

            $this->resource->setCsvPath($csvFile);

            $this->save();

            $this->queueworker->queue($this->resource);
//        }
    }

    /**
     * {@inheritDoc}
     */
    public function isMD5HashSame()
    {
        $md5 = $this->resource->getHash();

        $md5New = md5_file($this->resource->getUrl());

        if ($md5 === $md5New) {
            return true;
        }

        $this->resource->setHash($md5New);

        return false;
    }

    /**
     * Extract the downloaded file (zip to csv).
     *
     * @return string
     *   Path of the extracted CSV file.
     */
    private function extract()
    {
        if ($this->download()) {
            // Use the ZipArchive library (based on zlib).
            $zip = new \ZipArchive();

            if (true === $zip->open($this->archivePath)) {
                if (true === $zip->extractTo(sys_get_temp_dir())) {
                    $zip->close();

                    $csvFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.basename(
                        $this->archivePath,
                        '.zip'
                      ).'.csv';

                    return $csvFile;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        }
    }

    /**
     * Download the remote file to our temporary storage.
     *
     * @return bool
     */
    private function download()
    {
        $url = $this->resource->getUrl();
        $filename = basename($url);

        $newFilename = sys_get_temp_dir().DIRECTORY_SEPARATOR.$filename;

        $file = fopen($url, "rb");
        if ($file) {
            $newFile = fopen($newFilename, "wb");

            if ($newFile) {
                while (!feof($file)) {
                    fwrite($newFile, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }

        if ($file) {
            fclose($file);
        }

        if ($newFile) {
            $this->archivePath = $newFilename;
            fclose($newFile);

            return true;
        }

        return false;
    }

    protected function save()
    {
        $this->em->persist($this->resource);
        $this->em->flush();
    }

}
