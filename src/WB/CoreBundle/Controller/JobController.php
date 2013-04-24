<?php

namespace WB\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WB\CoreBundle\Entity\Job;
use WB\CoreBundle\Form\JobType;

/**
 * Job controller.
 *
 * @Route("/job")
 */
class JobController extends Controller
{
    /**
     * Lists all Job entities.
     *
     * @Route("/", name="job")
     * @Template("WBCoreBundle:Job:index.html.twig")
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $job_array = array();
        $em = $this->getDoctrine()->getManager();
        $job_array['ownJobs'] = $em->getRepository('WBCoreBundle:Job')->getOwnJobs(9);//$user->getID());
        $job_array['openJobs'] = $em->getRepository('WBCoreBundle:Job')->getOpenJobs();

        $workers = $em->getRepository('AcmeUserBundle:User')->getWorkers();
        $sheduledJobs = array();
        foreach ( $workers as $worker ){
            $sheduledJobs[] = $em->getRepository('WBCoreBundle:Job')->getSheduledJobsByUser($worker->getId());
        }
       // $job_array['sheduledJobs'] = $sheduledJobs;



        return array(
            'job_array' => $job_array,
        );
    }

    /**
     * Finds and displays a Job entity.
     *
     * @Route("/{id}/show", name="job_show")
     * @Template("WBCoreBundle:Job:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WBCoreBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Job entity.
     *
     * @Route("/new", name="job_new")
     * @Template("WBCoreBundle:Job:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Job();
        $form   = $this->createForm(new JobType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Job entity.
     *
     * @Route("/create", name="job_create")
     * @Method("POST")
     * @Template("WBCoreBundle:Job:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Job();
        $form = $this->createForm(new JobType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('job_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     * @Route("/{id}/edit", name="job_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WBCoreBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $editForm = $this->createForm(new JobType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Job entity.
     *
     * @Route("/{id}/update", name="job_update")
     * @Method("POST")
     * @Template("WBCoreBundle:Job:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WBCoreBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new JobType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('job_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Job entity.
     *
     * @Route("/{id}/delete", name="job_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WBCoreBundle:Job')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Job entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('job'));
    }
    
     /**
     * Deletes a Job entity.
     *
     * @Route("/{id}/dropdown", name="job_dropdown")
     * @Template("WBCoreBundle:Job:dropdown.html.twig")
     */
    public function dropdownAction(Request $request, $id){
         $em = $this->getDoctrine()->getManager();
         $entitys = $em->getRepository('WBCoreBundle:Job')->findAll($id);
  
         
        return array(
            'entitys'      => $entitys,
        );
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
