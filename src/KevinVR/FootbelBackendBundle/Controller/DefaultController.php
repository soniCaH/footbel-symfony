<?php

namespace KevinVR\FootbelBackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("/", name="admin_homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render(
          'FootbelBackendBundle:Default:index.html.twig'
        );
    }
}
