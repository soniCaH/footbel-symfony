<?php

namespace KevinVR\FootbalistoProcessorBundle\Command;

use KevinVR\FootbalistoProcessorBundle\Processor\ResourceFileProcessor;
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
            $output->writeln('Cannot connect to the queue!');
            exit(1);
        }

        $em = $this->getContainer()->get('doctrine')->getManager();
        $resourceRepository = $em->getRepository("FootbalistoBackendBundle:Resource");
        $resources = $resourceRepository->findResourcesToProcess();

        foreach ($resources as $resource) {
            $resourceFileProcessor = new ResourceFileProcessor(
                $resource,
                $queueworker,
                $em
            );
            $resourceFileProcessor->process();
        }
        if (count($resources) > 0) {
            $output->writeln(count($resources).' resources processed!');
        } else {
            $output->writeln('No resource to process!');
        }
        exit(0);
    }
}
