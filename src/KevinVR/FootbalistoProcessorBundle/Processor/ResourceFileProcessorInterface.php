<?php

namespace KevinVR\FootbalistoProcessorBundle\Processor;

interface ResourceFileProcessorInterface
{
    /**
     * Check the md5 hash of the remote file against the one in the database.
     *
     * @return bool
     */
    public function isMD5HashSame();

    /**
     * Add business logic to all the steps and automate them.
     *
     * @return bool
     */
    public function process();
}