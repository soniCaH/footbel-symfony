<?php

namespace KevinVR\FootbelProcessorBundle\Command;

use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResourceProcessorAllCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('resource:process:all');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $queueworker = $this->getContainer()->get('rabbit_worker');
        } catch (\Exception $e) {
            // @TODO: Logging!
            exit(1);
        }

        $em = $this->getContainer()->get('doctrine')->getManager();
        $resourceRepository = $em->getRepository("FootbelBackendBundle:Resource");
        $resources = $resourceRepository->findResourcesToProcess();

        foreach ($resources as $resource) {
            $resourceFileProcessor = new ResourceFileProcessor(
                $resource,
                $queueworker,
                $em
            );
            $resourceFileProcessor->process();
        }

        exit(0);
    }
}
