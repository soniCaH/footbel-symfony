<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

use KevinVR\FootbelBackendBundle\Entity\ResourceInterface;

interface ResourceQueueWorkerInterface
{
    public function queue(ResourceInterface $resource, $start = 0, $limit = 50);
//    public function remove(ResourceInterface $resource);
}