<?php

namespace KevinVR\FootbelBackendBundle\Controller;

use KevinVR\FootbelBackendBundle\Entity\Level;
use KevinVR\FootbelBackendBundle\Entity\Province;
use KevinVR\FootbelBackendBundle\Entity\Resource;
use KevinVR\FootbelBackendBundle\Entity\ResourceType;
use KevinVR\FootbelBackendBundle\Entity\Season;
use KevinVR\FootbelBackendBundle\Form\LevelForm;
use KevinVR\FootbelBackendBundle\Form\ResourceTypeForm;
use KevinVR\FootbelBackendBundle\Form\SeasonForm;
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
        $overviews = array(
            'resource_type_list' => 'Resource Type',
            'season_list' => 'Seasons',
            'level_list' => 'Levels',
            'province_list' => 'Provinces',
            'resource_list' => 'Resources',
        );

        $build['overviews'] = $overviews;

        return $this->render(
          'FootbelBackendBundle:Default:index.html.twig',
          $build
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/season",
     *     name="season_list"
     * )
     */
    public function listSeasonAction(Request $request)
    {
        $seasons = $this->getDoctrine()
          ->getRepository('FootbelBackendBundle:Season')
          ->findAll();

        $build['items'] = $seasons;
        $build['add_path'] = 'season_new';
        $build['edit_path'] = 'season_edit';
        $build['delete_path'] = 'season_delete';


        return $this->render(
          'FootbelBackendBundle:Default:list.html.twig',
          $build
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/resource_type",
     *     name="resource_type_list"
     * )
     */
    public function listResourceTypeAction(Request $request)
    {
        $seasons = $this->getDoctrine()
          ->getRepository('FootbelBackendBundle:ResourceType')
          ->findAll();

        $build['items'] = $seasons;
        $build['add_path'] = 'resource_type_new';
        $build['edit_path'] = 'resource_type_edit';
        $build['delete_path'] = 'resource_type_delete';


        return $this->render(
          'FootbelBackendBundle:Default:list.html.twig',
          $build
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/level",
     *     name="level_list"
     * )
     */
    public function listLevelAction(Request $request)
    {
        $seasons = $this->getDoctrine()
          ->getRepository('FootbelBackendBundle:Level')
          ->findAll();

        $build['items'] = $seasons;
        $build['add_path'] = 'level_new';
        $build['edit_path'] = 'level_edit';
        $build['delete_path'] = 'level_delete';


        return $this->render(
          'FootbelBackendBundle:Default:list.html.twig',
          $build
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/province",
     *     name="province_list"
     * )
     */
    public function listProvinceAction(Request $request)
    {
        $seasons = $this->getDoctrine()
          ->getRepository('FootbelBackendBundle:Province')
          ->findAll();

        $build['items'] = $seasons;
        $build['add_path'] = 'province_new';
        $build['edit_path'] = 'province_edit';
        $build['delete_path'] = 'province_delete';


        return $this->render(
          'FootbelBackendBundle:Default:list.html.twig',
          $build
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/resource",
     *     name="resource_list"
     * )
     */
    public function listResourceAction(Request $request)
    {
        $seasons = $this->getDoctrine()
          ->getRepository('FootbelBackendBundle:Resource')
          ->findAll();

        $build['items'] = $seasons;
        $build['add_path'] = 'resource_new';
        $build['edit_path'] = 'resource_edit';
        $build['delete_path'] = 'resource_delete';


        return $this->render(
          'FootbelBackendBundle:Default:list.html.twig',
          $build
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/season/new",
     *     name="season_new"
     * )
     */
    public function newSeasonAction(Request $request)
    {
        $season = new Season();

        $form = $this->createForm(SeasonForm::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($season);
            $em->flush();

            return $this->redirectToRoute('season_list');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/season/{id}/edit",
     *     name="season_edit",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function editSeasonAction($id, Request $request)
    {
        $season = $this->getDoctrine()
          ->getRepository('FootbelBackendBundle:Season')
          ->find($id);

        if (!$season) {
            throw $this->createNotFoundException(
              'No season found for id '.$id
            );
        }

        $form = $this->createForm(SeasonForm::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($season);
            $em->flush();

            return $this->redirectToRoute('season_list');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/resource_type/{id}/edit",
     *     name="resource_type_edit",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function editResourceTypeAction($id, Request $request)
    {
        $resourceType = $this->getDoctrine()
          ->getRepository('FootbelBackendBundle:ResourceType')
          ->find($id);

        if (!$resourceType) {
            throw $this->createNotFoundException(
              'No resource type found for id '.$id
            );
        }

        $form = $this->createForm(ResourceTypeForm::class, $resourceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resourceType);
            $em->flush();

            return $this->redirectToRoute('resource_type_list');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/level/{id}/edit",
     *     name="level_edit",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function editLevelAction($id, Request $request)
    {
        $level = $this->getDoctrine()
          ->getRepository('FootbelBackendBundle:Level')
          ->find($id);

        if (!$level) {
            throw $this->createNotFoundException(
              'No level found for id '.$id
            );
        }

        $form = $this->createForm(LevelForm::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($level);
            $em->flush();

            return $this->redirectToRoute('level_list');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/province/{id}/edit",
     *     name="province_edit",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function editProvinceAction($id, Request $request)
    {
        $province = $this->getDoctrine()
          ->getRepository('FootbelBackendBundle:Province')
          ->find($id);

        if (!$province) {
            throw $this->createNotFoundException(
              'No province found for id '.$id
            );
        }

        $form = $this->createForm(ProvinceForm::class, $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($province);
            $em->flush();

            return $this->redirectToRoute('province_list');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/resource/{id}/edit",
     *     name="resource_edit",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function editResourceAction($id, Request $request)
    {
        $season = $this->getDoctrine()
          ->getRepository('FootbelBackendBundle:Resource')
          ->find($id);

        if (!$season) {
            throw $this->createNotFoundException(
              'No resource found for id '.$id
            );
        }

        $form = $this->createForm(ResourceForm::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($season);
            $em->flush();

            return $this->redirectToRoute('resource_list');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/season/{id}/delete",
     *     name="season_delete",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function deleteSeasonAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $season = $em->getRepository('FootbelBackendBundle:Season')
          ->find($id);

        if (!$season) {
            throw $this->createNotFoundException(
              'No season found for id '.$id
            );
        }

        $em->remove($season);
        $em->flush();

        $this->addFlash('notice', 'Season deleted');

        return $this->redirectToRoute('season_list');

    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/resource_type/{id}/delete",
     *     name="resource_type_delete",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function deleteResourceTypeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $resourceType = $em->getRepository('FootbelBackendBundle:ResourceType')
          ->find($id);

        if (!$resourceType) {
            throw $this->createNotFoundException(
              'No resource type found for id '.$id
            );
        }

        $em->remove($resourceType);
        $em->flush();

        $this->addFlash('notice', 'Resource Type deleted');

        return $this->redirectToRoute('resource_type_list');

    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/level/{id}/delete",
     *     name="level_delete",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function deleteLevelAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $level = $em->getRepository('FootbelBackendBundle:Level')
          ->find($id);

        if (!$level) {
            throw $this->createNotFoundException(
              'No level found for id '.$id
            );
        }

        $em->remove($level);
        $em->flush();

        $this->addFlash('notice', 'Level deleted');

        return $this->redirectToRoute('level_list');

    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/province/{id}/delete",
     *     name="province_delete",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function deleteProvinceAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $province = $em->getRepository('FootbelBackendBundle:Province')
          ->find($id);

        if (!$province) {
            throw $this->createNotFoundException(
              'No province found for id '.$id
            );
        }

        $em->remove($province);
        $em->flush();

        $this->addFlash('notice', 'Province deleted');

        return $this->redirectToRoute('province_list');

    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/resource/{id}/delete",
     *     name="resource_delete",
     *     requirements={
     *         "id": "\d+"
     *     }
     * )
     */
    public function deleteResourceAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $resource = $em->getRepository('FootbelBackendBundle:Resource')
          ->find($id);

        if (!$resource) {
            throw $this->createNotFoundException(
              'No resource found for id '.$id
            );
        }

        $em->remove($resource);
        $em->flush();

        $this->addFlash('notice', 'Resource deleted');

        return $this->redirectToRoute('resource_list');

    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/resource/new",
     *     name="resource_new"
     * )
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

            return $this->redirectToRoute('resource_list');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/resource_type/new",
     *     name="resource_type_new"
     * )
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

            return $this->redirectToRoute('resource_type_list');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/level/new",
     *     name="level_new"
     * )
     */
    public function newLevelAction(Request $request)
    {
        $level = new Level();
        $form = $this->createForm(LevelForm::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($level);
            $em->flush();

            return $this->redirectToRoute('level_list');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route(
     *     "/province/new",
     *     name="province_new"
     * )
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

            return $this->redirectToRoute('province_list');
        }

        return $this->render(
          'FootbelBackendBundle:Default:new.html.twig',
          array(
            'form' => $form->createView(),
          )
        );
    }
}
