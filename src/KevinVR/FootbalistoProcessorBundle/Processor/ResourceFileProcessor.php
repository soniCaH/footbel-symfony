<?php

namespace KevinVR\FootbalistoProcessorBundle\Processor;

use Doctrine\ORM\EntityManager;
use KevinVR\FootbalistoBackendBundle\Entity\ResourceInterface;

/**
 * Class ResourceFileProcessor
 * @package KevinVR\FootbalistoProcessorBundle\Processor
 */
class ResourceFileProcessor implements ResourceFileProcessorInterface
{
    /**
     * @var \KevinVR\FootbalistoBackendBundle\Entity\ResourceInterface
     */
    private $resource;

    /**
     * @var \KevinVR\FootbalistoProcessorBundle\Processor\ResourceQueueWorkerInterface
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
     * @param \KevinVR\FootbalistoBackendBundle\Entity\ResourceInterface $resource
     * @param \KevinVR\FootbalistoProcessorBundle\Processor\ResourceQueueWorkerInterface $queueworker
     */
    public function __construct(
        ResourceInterface $resource,
        ResourceQueueWorkerInterface $queueworker,
        EntityManager $em
    ) {
        $this->resource = $resource;
        $this->queueworker = $queueworker;
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     */
    public function process()
    {
        if (!$this->isMD5HashSame()) {
            $csvFile = $this->extract();

            if (empty($csvFile) || !file_exists($csvFile)) {
                return;
            }

            $this->resource->setCsvPath($csvFile);
            $this->resource->setModified(1);

            $this->save();

            $this->queueworker->queue(
                $this->resource->getSeason()->getId(),
                $this->resource->getLevel()->getId(),
                ($this->resource->getProvince()) ? $this->resource->getProvince()->getId() : null,
                $this->resource->getCsvPath(),
                $this->resource->getType()->getHandler()
            );

            $this->resource->setQueued(new \DateTime());
            $this->save();
        } else {
            $this->resource->setModified(0);
            $this->resource->setChecked(new \DateTime());
            $this->resource->setQueued(null);
            $this->save();
        }

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

        return false;
    }

    /**
     * Extract the downloaded file (zip to csv).
     *
     * @return string
     *   Path of the extracted CSV file.
     */
    protected function extract()
    {
        if ($this->download()) {
            // Use the ZipArchive library (based on zlib).
            $zip = new \ZipArchive();

            if (true === $zip->open($this->archivePath)) {
                if (true === $zip->extractTo(sys_get_temp_dir())) {
                    $zip->close();

                    $csvFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.basename($this->archivePath, '.zip').'.csv';

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
    protected function download()
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

    /**
     * Persist the current resource.
     */
    protected function save()
    {
        $this->em->persist($this->resource);
        $this->em->flush();
    }

}
