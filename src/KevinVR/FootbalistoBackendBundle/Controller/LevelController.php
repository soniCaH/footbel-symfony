<?php

namespace KevinVR\FootbalistoBackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use KevinVR\FootbalistoBackendBundle\Entity\Level;
use KevinVR\FootbalistoBackendBundle\Form\LevelType;

/**
 * Level controller.
 *
 * @Route("/level")
 */
class LevelController extends Controller
{
    /**
     * Lists all Level entities.
     *
     * @Route("/", name="level_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $levels = $em->getRepository('FootbalistoBackendBundle:Level')->findAll();

        return $this->render('level/index.html.twig', array(
            'levels' => $levels,
        ));
    }

    /**
     * Creates a new Level entity.
     *
     * @Route("/new", name="level_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $level = new Level();
        $form = $this->createForm('KevinVR\FootbalistoBackendBundle\Form\LevelType', $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($level);
            $em->flush();

            return $this->redirectToRoute('level_show', array('id' => $level->getId()));
        }

        return $this->render('level/new.html.twig', array(
            'level' => $level,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Level entity.
     *
     * @Route("/{id}", name="level_show")
     * @Method("GET")
     */
    public function showAction(Level $level)
    {
        $deleteForm = $this->createDeleteForm($level);

        return $this->render('level/show.html.twig', array(
            'level' => $level,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Level entity.
     *
     * @Route("/{id}/edit", name="level_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Level $level)
    {
        $deleteForm = $this->createDeleteForm($level);
        $editForm = $this->createForm('KevinVR\FootbalistoBackendBundle\Form\LevelType', $level);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($level);
            $em->flush();

            return $this->redirectToRoute('level_edit', array('id' => $level->getId()));
        }

        return $this->render('level/edit.html.twig', array(
            'level' => $level,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Level entity.
     *
     * @Route("/{id}", name="level_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Level $level)
    {
        $form = $this->createDeleteForm($level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($level);
            $em->flush();
        }

        return $this->redirectToRoute('level_index');
    }

    /**
     * Creates a form to delete a Level entity.
     *
     * @param Level $level The Level entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Level $level)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('level_delete', array('id' => $level->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
