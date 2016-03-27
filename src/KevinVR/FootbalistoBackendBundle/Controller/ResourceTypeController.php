<?php

namespace KevinVR\FootbalistoBackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use KevinVR\FootbalistoBackendBundle\Entity\ResourceType;
use KevinVR\FootbalistoBackendBundle\Form\ResourceTypeType;

/**
 * ResourceType controller.
 *
 * @Route("/resourcetype")
 */
class ResourceTypeController extends Controller
{
    /**
     * Lists all ResourceType entities.
     *
     * @Route("/", name="resourcetype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $resourceTypes = $em->getRepository('FootbalistoBackendBundle:ResourceType')->findAll();

        return $this->render('resourcetype/index.html.twig', array(
            'resourceTypes' => $resourceTypes,
        ));
    }

    /**
     * Creates a new ResourceType entity.
     *
     * @Route("/new", name="resourcetype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $resourceType = new ResourceType();
        $form = $this->createForm('KevinVR\FootbalistoBackendBundle\Form\ResourceTypeType', $resourceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resourceType);
            $em->flush();

            return $this->redirectToRoute('resourcetype_show', array('id' => $resourceType->getId()));
        }

        return $this->render('resourcetype/new.html.twig', array(
            'resourceType' => $resourceType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ResourceType entity.
     *
     * @Route("/{id}", name="resourcetype_show")
     * @Method("GET")
     */
    public function showAction(ResourceType $resourceType)
    {
        $deleteForm = $this->createDeleteForm($resourceType);

        return $this->render('resourcetype/show.html.twig', array(
            'resourceType' => $resourceType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ResourceType entity.
     *
     * @Route("/{id}/edit", name="resourcetype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ResourceType $resourceType)
    {
        $deleteForm = $this->createDeleteForm($resourceType);
        $editForm = $this->createForm('KevinVR\FootbalistoBackendBundle\Form\ResourceTypeType', $resourceType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resourceType);
            $em->flush();

            return $this->redirectToRoute('resourcetype_edit', array('id' => $resourceType->getId()));
        }

        return $this->render('resourcetype/edit.html.twig', array(
            'resourceType' => $resourceType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ResourceType entity.
     *
     * @Route("/{id}", name="resourcetype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ResourceType $resourceType)
    {
        $form = $this->createDeleteForm($resourceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($resourceType);
            $em->flush();
        }

        return $this->redirectToRoute('resourcetype_index');
    }

    /**
     * Creates a form to delete a ResourceType entity.
     *
     * @param ResourceType $resourceType The ResourceType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ResourceType $resourceType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('resourcetype_delete', array('id' => $resourceType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
