<?php

namespace KevinVR\FootbelProcessorBundle\Controller;

use KevinVR\FootbelBackendBundle\Entity\Resource;
use KevinVR\FootbelBackendBundle\Repository\ResourceRepository;
use KevinVR\FootbelProcessorBundle\Processor\ResourceFileProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootbelBackendBundle:Resource');
        $resource = $repository->find(1);
        $resourceFileProcessor = new ResourceFileProcessor($resource);
        $resourceFileProcessor->process();


        var_dump($resource);
        $em->flush();

        return $this->render('FootbelProcessorBundle:Default:index.html.twig');
    }
}
