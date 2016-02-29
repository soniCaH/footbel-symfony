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
     * Retrieves all resources and queues them if needed (new MD5 hash).
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/", name="process_all")
     */
    public function processAllAction()
    {
        try {
            $queueworker = $this->get('rabbit_worker');
        } catch (\Exception $e) {
            $this->addFlash(
                'error',
                'Unable to connect to message queue.'
            );

            return $this->redirectToRoute('resource_index');
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("FootbelBackendBundle:Resource");

        $resources = $repository->findAll();

        foreach ($resources as $resource) {
            $resourceFileProcessor = new ResourceFileProcessor(
                $resource,
                $queueworker,
                $em
            );
            $resourceFileProcessor->process();
        }

        $this->addFlash(
            'notice',
            'All resources queued for processing!'
        );

        return $this->redirectToRoute('resource_index');
    }

    /**
     * Finds and processes a Resource entity.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Resource $resource
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}", name="process_go")
     */
    public function processAction(Resource $resource)
    {
        try {
            $queueworker = $this->get('rabbit_worker');
        } catch (\Exception $e) {
            $this->addFlash(
                'error',
                'Unable to connect to message queue.'
            );

            return $this->redirectToRoute('resource_index');
        }

        $em = $this->getDoctrine()->getManager();

        $resourceFileProcessor = new ResourceFileProcessor(
            $resource,
            $queueworker,
            $em
        );
        $resourceFileProcessor->process();

        $this->addFlash(
            'notice',
            'Resource queued for processing!'
        );

        // $this->addFlash is equivalent to $this->get('session')->getFlashBag()->add

        return $this->redirectToRoute('resource_index');

    }
}
