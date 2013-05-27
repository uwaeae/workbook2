<?php

namespace WB\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
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
        $ownJobs = $em->getRepository('WBCoreBundle:Job')->getOwnJobs($user->getID());//$user->getID());
        $openJobs = $em->getRepository('WBCoreBundle:Job')->getOpenJobs();

        $workers = $em->getRepository('AcmeUserBundle:User')->getWorkers();
        $sheduledJobs = array();
        foreach ( $workers as $worker ){
            $sheduledJobs[$worker->getUsername()] = array(
                'jobs'=> $em->getRepository('WBCoreBundle:Job')->getSheduledJobsByUser($worker->getId()),
                'user'=> $worker,
            );
        }
        $finishedJobs = $em->getRepository('WBCoreBundle:Job')->getFinishedJobs();

       // $job_array['sheduledJobs'] = $sheduledJobs;



        return array(
            'ownJobs' => $ownJobs,
            'openJobs' =>$openJobs,
            'sheduledJobs' => $sheduledJobs,
            'finishedJobs' => $finishedJobs,
        );
    }
    /**
     * Render Job Table for the Job overview
     *
     * @Route("/table/{type}", name="job_table")
     * @Method("get")

     */
    public function tableAction(Request $request,$type)
    {
        $em = $this->getDoctrine()->getManager();
        $result = array();
        $user = $this->get('security.context')->getToken()->getUser();
        switch($type){
            case 'ownJobs':
                $result = $em->getRepository('WBCoreBundle:Job')->getOwnJobs($user->getID());
                break;
            case 'openJobs':
                $result = $em->getRepository('WBCoreBundle:Job')->getOpenJobs();
                break;
            case 'sheduledJobs':
                $username = $request->get('user');
                $user = $em->getRepository('AcmeUserBundle:User')->findOneBy(array('username'=>$username));
                if($user) $result = $em->getRepository('WBCoreBundle:Job')->getSheduledJobsByUser($user->getID());
                break;

            case 'workedJobs':
                if ($this->get('security.context')->isGranted('ROLE_ADMIN')){
                    $result = $em->getRepository('WBCoreBundle:Job')->getWorkedJobs();
                }else{
                    $result = $em->getRepository('WBCoreBundle:Job')->getWorkedJobsByUser($user->getID());
                }
                break;
            case 'finishedJobs':
                if ($this->get('security.context')->isGranted('ROLE_ADMIN')){
                    $result = $em->getRepository('WBCoreBundle:Job')->getFinishedJobs();
                }
                break;

        }
        $json = array();
        foreach($result as $job){
            $j = array();
            $j['id'] = $job->getID();

            $j['customer'] = $job->getAddress()->getCustomer()->getCompany();
            $j['address1'] = $job->getAddress()->getStreet().' '.$job->getAddress()->getNumber();
            $j['address2'] = $job->getAddress()->getPostcode().' '.$job->getAddress()->getCity().' '.$job->getAddress()->getDestrict();
            $j['description'] = $job->getDescription();
            $j['type'] = $job->getJobtype()->getID();
            $j['type_name'] = $job->getJobtype()->getName();
            $j['from'] = $job->getStart()->format("d.m.y H:i");
            $j['to'] = $job->getEnd()->format("d.m.y H:i");


            $json[] = $j;
        }


        $response = new Response( json_encode($json));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }



    /**
     * Render Tasks for the Job overview
     *
     * @Route("/scheduledTasks", name="job_scheduledTasks")
     * @Method("post")
     */
    public function scheduledTasksAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $jobs = $request->request->get('jobs');
        $json = array();
        foreach($jobs as $job){
            $tasks = $em->getRepository('WBCoreBundle:Task')->getScheduledTasksForJob($job);
            $ts =array();
            foreach($tasks as $task){
                $t= array();
                $t['date'] = $task->getStart()->format("d.m.y H:i");
                $u = '';
                foreach($task->getUser() as $user){
                    $u.= ' '.$user->getUsername();
                }
                $t['user'] = $u;
                $ts[] = $t;
            }
            $json[$job] = $ts;
        }

        $response = new Response( json_encode($json));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

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
