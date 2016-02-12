<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class ResourceProcessorMatch
 * @package KevinVR\FootbelProcessorBundle\Processor
 */
class ResourceProcessorMatch implements ConsumerInterface
{
    private $resource;
    private $start;
    private $limit;

    /**
     * @param \PhpAmqpLib\Message\AMQPMessage $msg
     * @return mixed
     */
    public function execute(AMQPMessage $msg)
    {
        $params = unserialize($msg->body);

        $this->resource = $params['resource'];
        $this->start = $params['start'];
        $this->limit = $params['limit'];

        // While start++ < limit { process } then queue again from that point.
    }


}