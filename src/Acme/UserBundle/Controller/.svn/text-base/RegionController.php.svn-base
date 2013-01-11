<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\UserBundle\Entity\Region;
use Acme\UserBundle\Form\RegionType;

/**
 * Region controller.
 *
 */
class RegionController extends Controller
{
    /**
     * Lists all Region entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $_entities = $em->getRepository('AcmeUserBundle:Region')->findAll();
        $entities = array();
        foreach($_entities as $entity){
                $activateForm = $this->createActivateForm($entity->getId());
                $entity->activateForm = $activateForm->createView();
                $entities[strtolower(substr($entity->getName(),0,1))][] = $entity;
        }
        ksort($entities);
        return $this->render('AcmeUserBundle:Region:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Region entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeUserBundle:Region')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeUserBundle:Region:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Region entity.
     *
     */
    public function newAction()
    {
        $entity = new Region();
        $form   = $this->createForm(new RegionType(), $entity);

        return $this->render('AcmeUserBundle:Region:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Region entity.
     *
     */
    public function createAction()
    {
        $entity  = new Region();
        $request = $this->getRequest();
        $form    = $this->createForm(new RegionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('region_edit', array('id' => $entity->getId())));
            
        }

        return $this->render('AcmeUserBundle:Region:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Region entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeUserBundle:Region')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $editForm = $this->createForm(new RegionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeUserBundle:Region:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Region entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeUserBundle:Region')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $editForm   = $this->createForm(new RegionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('region_edit', array('id' => $id)));
        }

        return $this->render('AcmeUserBundle:Region:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Region entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeUserBundle:Region')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Region entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('region'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Deactivate or activate a Region entity.
     *
     */
    public function activateAction($id)
    {
        $form = $this->createActivateForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeUserBundle:Region')->find($id);

            $active = $entity->getDisabled() ? false : true;
            $entity->setDisabled($active);

            $modifieduser = $this->get('security.context')->getToken()->getUser();
            $entity->setModifiedUser($modifieduser->getId());

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Region entity.');
            }

            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('region'));
    }

    private function createActivateForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
            ;
    }
}
