<?php

namespace KevinVR\FootbelProcessorBundle\Controller;

use Assetic\Factory\Resource\ResourceInterface;
use KevinVR\FootbelBackendBundle\Entity\Resource;
use KevinVR\FootbelBackendBundle\Repository\ResourceRepository;
use KevinVR\FootbelProcessorBundle\Processor\ResourceFileProcessor;
use KevinVR\FootbelProcessorBundle\Processor\ResourceQueueWorkerRabbitMQ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('FootbelProcessorBundle:Default:index.html.twig');
    }

    /**
     * Finds and processes a Resource entity.
     *
     * @Route("/{id}", name="process_go")
     */
    public function processAction(Resource $resource)
    {
        $queueworker = new ResourceQueueWorkerRabbitMQ($this->get('old_sound_rabbit_mq.process_match_producer'));

        $em = $this->getDoctrine()->getManager();

        $resourceFileProcessor = new ResourceFileProcessor($resource, $queueworker, $em);
        $resourceFileProcessor->process();

        return $this->render('FootbelProcessorBundle:Default:index.html.twig');
    }
}
