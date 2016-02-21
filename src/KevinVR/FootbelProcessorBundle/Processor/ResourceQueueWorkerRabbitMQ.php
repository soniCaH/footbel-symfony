<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

/**
 * Class ResourceQueueWorkerRabbitMQ
 * @package KevinVR\FootbelProcessorBundle\Processor
 */
class ResourceQueueWorkerRabbitMQ implements ResourceQueueWorkerInterface
{
    /**
     * @var \OldSound\RabbitMqBundle\RabbitMq\Producer
     */
    private $rabbitService;

    /**
     * ResourceQueueWorkerRabbitMQ constructor.
     * @param \OldSound\RabbitMqBundle\RabbitMq\Producer $rabbitProducer
     */
    public function __construct($rabbitProducer)
    {
        $this->rabbitService = $rabbitProducer;
    }

    /**
     * @param string $filepath
     * @param string $handler
     * @param int    $start
     * @param int    $limit
     *
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