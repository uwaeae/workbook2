<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\UserBundle\Entity\Group;
use Acme\UserBundle\Form\GroupType;

/**
 * Group controller.
 *
 */
class GroupController extends Controller
{
    /**
     * Lists all Group entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $_entities = $em->getRepository('AcmeUserBundle:Group')->findAll();

        $entities = array();
        foreach($_entities as $entity){
            $deleteForm = $this->createDeleteForm($entity->getId());
            $entity->deleteForm = $deleteForm->createView();
            $entities[strtolower(substr($entity->getName(),0,1))][] = $entity;
        }

        return $this->render('AcmeUserBundle:Group:index.html.twig', array(
            'entities' => $entities,
            'isAdmin'  => $this->get('security.context')->isGranted('ROLE_ADMIN')
        ));
    }

    /**
     * Finds and displays a Group entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeUserBundle:Group')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeUserBundle:Group:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'isAdmin'  => $this->get('security.context')->isGranted('ROLE_ADMIN')
        ));
    }

    /**
     * Displays a form to create a new Group entity.
     *
     */
    public function newAction()
    {
        $entity = new Group();
        $form   = $this->createForm(new GroupType(), $entity);

        return $this->render('AcmeUserBundle:Group:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'isAdmin'  => $this->get('security.context')->isGranted('ROLE_ADMIN')
        ));
    }

    /**
     * Creates a new Group entity.
     *
     */
    public function createAction()
    {
        $entity  = new Group();
        $request = $this->getRequest();
        $form    = $this->createForm(new GroupType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('group_edit', array('id' => $entity->getId())));
            
        }

        return $this->render('AcmeUserBundle:Group:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'isAdmin'  => $this->get('security.context')->isGranted('ROLE_ADMIN')
        ));
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeUserBundle:Group')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        $editForm = $this->createForm(new GroupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeUserBundle:Group:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'isAdmin'  => $this->get('security.context')->isGranted('ROLE_ADMIN')
        ));
    }

    /**
     * Edits an existing Group entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeUserBundle:Group')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        $editForm   = $this->createForm(new GroupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('group_edit', array('id' => $id)));
        }

        return $this->render('AcmeUserBundle:Group:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'isAdmin'  => $this->get('security.context')->isGranted('ROLE_ADMIN')
        ));
    }

    /**
     * Deletes a Group entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeUserBundle:Group')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Group entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('group'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
