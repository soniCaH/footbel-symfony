<?php

namespace KevinVR\FootbelBackendBundle\Controller;

use KevinVR\FootbelBackendBundle\Entity\Level;
use KevinVR\FootbelBackendBundle\Entity\Province;
use KevinVR\FootbelBackendBundle\Entity\Resource;
use KevinVR\FootbelBackendBundle\Entity\ResourceType;
use KevinVR\FootbelBackendBundle\Entity\Season;
use KevinVR\FootbelBackendBundle\Form\ResourceTypeForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use KevinVR\FootbelBackendBundle\Form\ProvinceForm;
use KevinVR\FootbelBackendBundle\Form\ResourceForm;

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
        $season = new Season();

        $form = $this->createForm(ProvinceForm::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($season);
            $em->flush();

            return $this->redirectToRoute('season_new');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("/resource/new", name="resource_new")
     */
    public function newResourceAction(Request $request)
    {
        $resource = new Resource();
        $form = $this->createForm(ResourceForm::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resource);
            $em->flush();

            return $this->redirectToRoute('resource_new');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("/resource_type/new", name="resource_type_new")
     */
    public function newResourceTypeAction(Request $request)
    {
        $resourceType = new ResourceType();
        $form = $this->createForm(ResourceTypeForm::class, $resourceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($resourceType);
            $em->flush();

            return $this->redirectToRoute('resource_type_new');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("/level/new", name="level_new")
     */
    public function newLevelAction(Request $request)
    {
        $level = new Level();
        $form = $this->createForm(ProvinceForm::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($level);
            $em->flush();

            return $this->redirectToRoute('level_new');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("/province/new", name="province_new")
     */
    public function newProvinceAction(Request $request)
    {
        $province = new Province();
        $form = $this->createForm(ProvinceForm::class, $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($province);
            $em->flush();

            return $this->redirectToRoute('province_new');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }
}
