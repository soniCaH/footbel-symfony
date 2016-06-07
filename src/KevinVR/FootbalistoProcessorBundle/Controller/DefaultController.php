<?php

namespace KevinVR\FootbalistoProcessorBundle\Controller;

use Assetic\Factory\Resource\ResourceInterface;
use KevinVR\FootbalistoBackendBundle\Entity\Resource;
use KevinVR\FootbalistoBackendBundle\Repository\ResourceRepository;
use KevinVR\FootbalistoProcessorBundle\Processor\ResourceFileProcessor;
use KevinVR\FootbalistoProcessorBundle\Processor\ResourceQueueWorkerRabbitMQ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    /**
     * Retrieves all resources and queues them if needed (new MD5 hash).
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/", name="process_all")
     */
    public function processAllAction(Request $request)
    {
        try {
            $queueworker = $this->get('rabbit_worker');
        } catch (\Exception $e) {
            $this->addFlash(
                'error',
                'Unable to connect to message queue.'
            );

            $user = $this->getUser();
            $this->container->get('google_analytics')->sendData($request, 'process_all_failed', $user);

            return $this->redirectToRoute('resource_index');
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("FootbalistoBackendBundle:Resource");

        $resources = $repository->findResourcesToProcess();

        $dt = new \DateTime();

        foreach ($resources as $resource) {
            if ($resource->getSeason()->getStart() <= $dt && $resource->getSeason()->getEnd() >= $dt) {
                $resourceFileProcessor = new ResourceFileProcessor(
                    $resource,
                    $queueworker,
                    $em
                );
                $resourceFileProcessor->process();
            }
        }

        $this->addFlash(
            'notice',
            'All resources queued for processing!'
        );

        $user = $this->getUser();
        $this->container->get('google_analytics')->sendData($request, 'process_all', $user);

        return $this->redirectToRoute('resource_index');
    }

    /**
     * Finds and processes a Resource entity.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Resource $resource
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}", name="process_go")
     */
    public function processAction(Resource $resource, Request $request)
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

        $user = $this->getUser();
        $this->container->get('google_analytics')->sendData($request, 'process_one', $user);

        return $this->redirectToRoute('resource_index');

    }
}
