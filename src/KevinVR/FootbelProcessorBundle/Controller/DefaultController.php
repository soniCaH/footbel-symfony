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
//        $rep = $this->getDoctrine()->getRepository('FootbelBackendBundle:Resource');
//
//        $resource = $rep->find(1);
//
//        var_dump($resource->getType()->getHandler());

        return $this->render('FootbelProcessorBundle:Default:index.html.twig');
    }

    /**
     * Finds and processes a Resource entity.
     *
     * @Route("/{id}", name="process_go")
     */
    public function processAction(Resource $resource)
    {
        $queueworker = $this->get('rabbit_worker');

        $em = $this->getDoctrine()->getManager();

        $resourceFileProcessor = new ResourceFileProcessor($resource, $queueworker, $em);
        $resourceFileProcessor->process();

        return $this->render('FootbelProcessorBundle:Default:index.html.twig');
    }
}
