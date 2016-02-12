<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

use KevinVR\FootbelBackendBundle\Entity\ResourceInterface;

class ResourceQueueWorkerRabbitMQ implements ResourceQueueWorkerInterface
{
    private $rabbitService;

    public function __construct($service)
    {
        $this->rabbitService = $service;
    }

    /**
     * @param \KevinVR\FootbelBackendBundle\Entity\ResourceInterface $resource
     * @param int $start
     * @param int $limit
     * @return mixed
     */
    public function queue(ResourceInterface $resource, $start = 0, $limit = 50)
    {
        $msg = array('resource' => $resource, 'start' => $start, 'limit' => $limit);
        var_dump($msg);
        $this->rabbitService->publish(serialize($msg));
    }


}