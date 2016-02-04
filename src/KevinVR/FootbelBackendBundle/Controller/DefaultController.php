<?php

namespace KevinVR\FootbelBackendBundle\Controller;

use KevinVR\FootbelBackendBundle\Entity\Resource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package KevinVR\FootbelBackendBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Default homepage action.
     *
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("/")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $resource = new Resource('match', '2015-2016', 'nat', null, 'http://iets');

        $em = $this->getDoctrine()->getManager();

        $em->persist($resource);
        $em->flush();

        return new Response('Created resource with id '.$resource->getId());
    }
}
