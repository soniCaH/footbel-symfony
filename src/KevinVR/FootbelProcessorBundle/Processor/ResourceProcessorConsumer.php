<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

use Doctrine\ORM\EntityManager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class ResourceProcessorMatch
 * @package KevinVR\FootbelProcessorBundle\Processor
 */
class ResourceProcessorConsumer implements ConsumerInterface
{
    private $season;
    private $level;
    private $province;
    private $file;
    private $handler;
    private $start;
    private $limit;

    private $queueworker;
    private $entityManager;

    public function __construct(
        ResourceQueueWorkerInterface $rabbitWorker,
        EntityManager $entityManager
    ) {
        $this->queueworker = $rabbitWorker;
        $this->entityManager = $entityManager;
    }

    /**
     * @param \PhpAmqpLib\Message\AMQPMessage $msg
     * @return mixed
     */
    public function execute(AMQPMessage $msg)
    {
        $params = unserialize($msg->body);

        $this->season = $params['season'];
        $this->level = $params['level'];
        $this->province = $params['province'];
        $this->file = $params['file'];
        $this->handler = $params['handler'];
        $this->start = $params['start'];
        $this->limit = $params['limit'];

        $this->process();
    }

    private function process()
    {
        $parser = CSVIterator::createFromFilePath($this->file)
            ->setDelimiter(';')
            ->setHasHeader(true)
            ->setStartByte((int)$this->start);


        $parser = new \LimitIterator($parser, 0, $this->limit);

        $total = filesize($this->file);

        $header = $parser->getHeader();

        foreach ($parser as $row) {
            $item = array();
            foreach ($row as $delta => $cell) {
                $key = isset($header[$delta]) ? $header[$delta] : $delta;
                $item[$key] = $cell;
            }

            $result[] = $item;

            $handler = new $this->handler($this->entityManager);
            $handler->process($this->season, $this->level, $this->province, $item);
        }

        if ($parser->lastLinePos() < $total) {
            $this->queueworker->queue(
                $this->season,
                $this->level,
                $this->province,
                $this->file,
                $this->handler,
                $parser->lastLinePos()
            );
        } else {
            // Is finished.
            // Set queued = 0, modified to FALSE.
            $resource = $this->entityManager->getRepository(
                'FootbelBackendBundle:Resource'
            )->findOneBy(array('csv_path' => $this->file));

            $resource->setModified(0);
            $resource->setQueued(null);
            $resource->setChecked(new \DateTime());

            $md5New = md5_file($resource->getUrl());

            $resource->setHash($md5New);

            $this->entityManager->persist($resource);
            $this->entityManager->flush();
        }
    }
}