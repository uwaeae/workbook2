<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Acme\UserBundle\Entity\User;
use Acme\UserBundle\Form\UserType;
use Acme\UserBundle\Form\UserTypeForManager;
use Acme\UserBundle\Form\UserTypeForTranslator;
use Acme\UserBundle\Form\UserShow;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $isAdmin = $this->get('security.context')->isGranted('ROLE_ADMIN');
        $user = $this->get('security.context')->getToken()->getUser();
        $_entities = $em->getRepository('AcmeUserBundle:User')->findAll();

        $entities = array();
        foreach ($_entities as $entity) {
            if ($entity->getId() != 1 || ($isAdmin && $user->getId() == 1)) {
                $deleteForm = $this->createDeleteForm($entity->getId());
                $entity->deleteForm = $deleteForm->createView();
                $activateForm = $this->createActivateForm($entity->getId());
                $entity->activateForm = $activateForm->createView();
                $entities[strtolower(substr($entity->getLastname(), 0, 1))][] = $entity;
            }
        }
        ksort($entities);
        return $this->render('AcmeUserBundle:User:index.html.twig', array(
            'entities' => $entities,
            'isAdmin' => $isAdmin
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }



        $formType =  new UserShow();

        $editForm = $this->createForm($formType, $entity);

        return $this->render('AcmeUserBundle:User:show.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),


        ));
    }

    public function updateProfileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $updated = false;
        $entity = $em->getRepository('AcmeUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $oldpassword = $entity->getPassword();
        $oldfile = $entity->getFile();

        $editForm = $this->createForm(new UserShow(), $entity);
        $request = $this->getRequest();
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $modifieduser = $this->get('security.context')->getToken()->getUser();
            $entity->setModifiedUser($modifieduser->getId());

            if (strlen($entity->getPassword()) > 0) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($entity);
                $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
                $entity->setPassword($password);
            } else {
                $entity->setPassword($oldpassword);
            }

            if ($entity->getFile()->upload()) $em->persist($entity->getFile());
            else if ($oldfile == null) $entity->setFile(null);


            $em->persist($entity);
            $em->flush();

            $updated = true;

            //return $this->redirect($this->generateUrl('user_myprofile', array('id' => $id)));
        }



        return $this->render('AcmeUserBundle:User:show.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'updated' => $updated,
        ));
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $entity = new User();

        $form =  $this->get('security.context')->isGranted('ROLE_ADMIN') ? $this->createForm(new UserType(), $entity) : $this->createForm(new UserTypeForManager(), $entity);



        return $this->render('AcmeUserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),

        ));
    }

    /**
     * Creates a new User entity.
     *
     */
    public function createAction()
    {
        $entity = new User();
        $request = $this->getRequest();
        $form = $this->get('security.context')->isGranted('ROLE_ADMIN') ? $this->createForm(new UserType(), $entity) : $this->createForm(new UserTypeForManager(), $entity);
        $form->bind($request);


        if ($form->isValid()) {

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
            $entity->setPassword($password);
            $entity->setDeleted(false);


            $modifieduser = $this->get('security.context')->getToken()->getUser();
            $entity->setModifiedUser($modifieduser->getId());

            $em = $this->getDoctrine()->getManager();
            if ($entity->getFile()->upload()) $em->persist($entity->getFile());
            else $entity->setFile(null);

            //If no Role defined set ROLE_USER
            if($entity->getGroups() && count($entity->getGroups()) == 0){
                $userGroup = $em->getRepository('AcmeUserBundle:Group')->findOneByRole('ROLE_USER');
                if($userGroup != null){
                    $entity->getGroups()->add($userGroup);
                }
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_edit', array('id' => $entity->getId())));

        }

        return $this->render('AcmeUserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),

        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeUserBundle:User')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }


        $editForm = $this->get('security.context')->isGranted('ROLE_ADMIN') ? $this->createForm(new UserType(), $entity) : $this->createForm(new UserTypeForManager(), $entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeUserBundle:User:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $oldpassword = $entity->getPassword();
        $oldfile = $entity->getFile();
        $editForm = $this->get('security.context')->isGranted('ROLE_ADMIN') ? $this->createForm(new UserType(), $entity) : $this->createForm(new UserTypeForManager(), $entity);

        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $modifieduser = $this->get('security.context')->getToken()->getUser();
            $entity->setModifiedUser($modifieduser->getId());

            if (strlen($entity->getPassword()) > 0) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($entity);
                $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
                $entity->setPassword($password);
            } else {
                $entity->setPassword($oldpassword);
            }

            if ($entity->getFile()->upload()) $em->persist($entity->getFile());
            else if ($oldfile == null) $entity->setFile(null);

            //If no Role defined set ROLE_USER
            if($entity->getGroups() && count($entity->getGroups()) == 0){
                $userGroup = $em->getRepository('AcmeUserBundle:Group')->findOneByRole('ROLE_USER');
                if($userGroup != null){
                    $entity->getGroups()->add($userGroup);
                }
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return $this->render('AcmeUserBundle:User:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeUserBundle:User')->find($id);
            $entity->setDeleted(true);
            $entity->setIsActive(false);

            $modifieduser = $this->get('security.context')->getToken()->getUser();
            $entity->setModifiedUser($modifieduser->getId());

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }

    /**
     * Deactivate or activate a User entity.
     *
     */
    public function activateAction($id)
    {
        $form = $this->createActivateForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeUserBundle:User')->find($id);

            $active = $entity->getIsActive() ? false : true;
            $entity->setIsActive($active);

            $modifieduser = $this->get('security.context')->getToken()->getUser();
            $entity->setModifiedUser($modifieduser->getId());

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    private function createActivateForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }

    public function resetpasswordAction(Request $request, $c='', $u='')
    {

        $form = $this->createFormBuilder()
            ->add('user', 'text')
            ->getForm();

        $error = false;
        $info = false;
        $em = $this->getDoctrine()->getManager();
        if(!empty($c) && !empty($u)){

            try{
                $user = $em->getRepository('AcmeUserBundle:User')->loadUserByUsername($u);
                if($user){
                    $requestCode = $user->getRequestCode();
                    if($requestCode != null && $requestCode == $c){
                        $password = $this->generatePassword();
                        $factory = $this->get('security.encoder_factory');
                        $encoder = $factory->getEncoder($user);

                        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
                        $user->setRequestCode(null);
                        $em->persist($user);
                        $em->flush();

                        $message = \Swift_Message::newInstance()
                            ->setSubject('Continental Tire Managment')
                            ->setFrom('admin@conti-ctm.com')
                            ->setTo($user->getEmail())
                            ->setBody($this->renderView('AcmeUserBundle:User:resetPassword.txt.twig', array(
                            'user' => $user,
                            'password' => $password

                        )));
                        $this->get('mailer')->send($message);
                        $info = 'request.successfully';
                    }
                }else{
                    $error = 'request.codefailed';
                }
            }catch(\Exception $e){
                $error = 'request.failed';
            }
        }
        else if ($request->getMethod() == 'POST') {
            $data = $request->request->get('form');
            try{
                $user = $em->getRepository('AcmeUserBundle:User')->loadUserByUsername($data['user']);
                if ($user) {
                    $code = sha1(time() . $user->getUsername());

                    $user->setRequestCode($code);
                    $em->persist($user);
                    $em->flush();

                    $url = 'http://' . $_SERVER['HTTP_HOST'] . '/resetPassword/'.$code.'/'.$user->getUsername();

                    $message = \Swift_Message::newInstance()
                        ->setSubject('Continental Tire Managment')
                        ->setFrom('admin@conti-ctm.com')
                        ->setTo($user->getEmail())
                        ->setBody($this->renderView('AcmeUserBundle:User:requestPassword.txt.twig', array(
                        'user' => $user,
                        'url' => $url

                    )));
                    $this->get('mailer')->send($message);
                    $info = 'request.successfully';
                }
            }catch(\Exception $e){
                $error = 'request.failed';
            }

        }
        return $this->render('AcmeUserBundle:User:resetPassword.html.twig', array(
            'form' => $form->createView(),
            'info' => $info,
            'error' => $error
        ));

    }

    private function generatePassword($length = 8, $strength = 0)
    {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

}
