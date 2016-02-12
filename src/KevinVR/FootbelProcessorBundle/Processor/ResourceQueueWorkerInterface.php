<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

use KevinVR\FootbelBackendBundle\Entity\ResourceInterface;

interface ResourceQueueWorkerInterface
{
    public function queue($filepath, $handler, $start = 0, $limit = 50);
}