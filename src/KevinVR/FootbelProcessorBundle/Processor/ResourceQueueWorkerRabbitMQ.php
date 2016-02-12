<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

use Doctrine\ORM\EntityManager;
use KevinVR\FootbelBackendBundle\Entity\ResourceInterface;

class ResourceQueueWorkerRabbitMQ implements ResourceQueueWorkerInterface
{
    private $rabbitService;

    public function __construct($rabbitProducer)
    {
        $this->rabbitService = $rabbitProducer;
    }

    /**
     * @param string $filepath
     * @param string $handler
     * @param int $start
     * @param int $limit
     * @return mixed
     */
    public function queue($filepath, $handler, $start = 0, $limit = 50)
    {
        $msg = array(
          'file' => $filepath,
          'handler' => $handler,
          'start' => $start,
          'limit' => $limit,
        );
        $this->rabbitService->publish(serialize($msg));
    }

}