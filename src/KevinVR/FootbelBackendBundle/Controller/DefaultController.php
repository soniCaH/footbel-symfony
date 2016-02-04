<?php

namespace KevinVR\FootbelBackendBundle\Controller;

use KevinVR\FootbelBackendBundle\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use KevinVR\FootbelBackendBundle\Form\SeasonType;

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

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("/season/new", name="season_new")
     */
    public function newSeasonAction(Request $request)
    {
        $season = new Season(
          '1516',
          '2015 - 2016',
          new \DateTime('July 1 2015'),
          new \DateTime('June 30 2016')
        );

        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            return $this->redirectToRoute('task_success');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }
}
