<?php

namespace WB\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use WB\CoreBundle\Entity\Customer;
use WB\CoreBundle\Form\CustomerType;

/**
 * Customer controller.
 *
 * @Route("/customer")
 */
class CustomerController extends Controller
{
    /**
     * Lists all Customer entities.
     *
     * @Route("/", name="customer")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WBCoreBundle:Customer')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Customer entity.
     *
     * @Route("/{id}/show", name="customer_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WBCoreBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Finds and displays a Customer entity.
     *
     * @Route("/search/{therm}", name="customer_search")
     * @Template()
     */
    public function searchAction($therm)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb->add('select', 'c,a')
            ->add('from', 'WBCoreBundle:Customer c')
            ->innerJoin('c.Address', 'a')
            ->add('where', $qb->expr()->like('c.company', '?1'))

                    ->setParameter('1', '%'.$therm.'%');
        $result = $qb->getQuery()->getArrayResult();



        $response = new Response( json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * Displays a form to create a new Customer entity.
     *
     * @Route("/new", name="customer_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Customer();
        $form   = $this->createForm(new CustomerType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Customer entity.
     *
     * @Route("/create", name="customer_create")
     * @Method("POST")
     * @Template("WBCoreBundle:Customer:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Customer();
        $form = $this->createForm(new CustomerType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('customer_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Customer entity.
     *
     * @Route("/{id}/edit", name="customer_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WBCoreBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $editForm = $this->createForm(new CustomerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Customer entity.
     *
     * @Route("/{id}/update", name="customer_update")
     * @Method("POST")
     * @Template("WBCoreBundle:Customer:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WBCoreBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CustomerType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('customer_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Customer entity.
     *
     * @Route("/{id}/delete", name="customer_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WBCoreBundle:Customer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Customer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('customer'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
