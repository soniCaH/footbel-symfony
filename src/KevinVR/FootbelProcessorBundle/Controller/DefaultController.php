<?php

namespace KevinVR\FootbelProcessorBundle\Controller;

use Assetic\Factory\Resource\ResourceInterface;
use KevinVR\FootbelBackendBundle\Entity\Resource;
use KevinVR\FootbelBackendBundle\Repository\ResourceRepository;
use KevinVR\FootbelProcessorBundle\Processor\ResourceFileProcessor;
use KevinVR\FootbelProcessorBundle\Processor\ResourceQueueWorkerRabbitMQ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller {
  /**
   * Finds and processes a Resource entity.
   *
   * @Route("/{id}", name="process_go")
   */
  public function processAction(Resource $resource) {
    try {
      $queueworker = $this->get('rabbit_worker');
    }
    catch (\Exception $e) {
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
