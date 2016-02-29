<?php

namespace KevinVR\FootbelProcessorBundle\Command;

use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResourceProcessorCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->addArgument('resource', InputArgument::REQUIRED)
            ->setName('resource:processing');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = base64_decode($input->getArgument('resource'));

        $message = new AMQPMessage($data);

        /** @var \OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface $consumer */
        $consumer = $this->getContainer()->get('process_resource_service');

        if (false === $consumer->execute($message)) {
            exit(1);
        }

        exit(0);
    }
}
