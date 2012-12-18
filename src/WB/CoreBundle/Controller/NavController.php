<?php

namespace WB\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NavController extends Controller
{
    /**
     * @Route("/navbar}")
     * @Template("navbar.html.twig")
     */
    public function navbarAction()
    {

       $request = $this->getRequest();
        $path = $request->getPathInfo(); // the URI path being requested

        $modul = strtok($path,"/");


        $user = $this->get('security.context')->getToken()->getUser();
        $navigation_left = array();
        $navigation_right = array();
        $router = $this->get('router');
        $translator =  $this->get('translator');



        if(is_object($user)){
            $navigation_left['Calendar']      = array('label' => 'navigation.calendar', 'url' => '#', 'isActive'=>$modul == 'calendar'? true : false);
            $navigation_left['Jobs']      = array('label' => 'navigation.job', 'url' => $router->generate('job'), 'isActive'=> $modul == 'job'? true : false);
            $navigation_left['Customers']      = array('label' => 'navigation.customers', 'url' => $router->generate('customer'), 'isActive'=>$modul == 'customer'? true : false);
            $navigation_left['Archive']      = array('label' => 'navigation.archive', 'url' => '#', 'isActive'=>$modul == 'archive'? true : false);
            $navigation_left['Payroll']      = array('label' => 'navigation.payroll', 'url' => '#', 'isActive'=>$modul == 'payroll'? true : false);



        }
        return $this->render('WBCoreBundle:nav:navbar.html.twig', array(
                'navigation_left'  => $navigation_left,
                'navigation_right' => $navigation_right,
            )
        );



    }

    /**
     * @Route("/")
     * @Template("index.html.twig")
     */
    public function indexAction()
    {

        return $this->render('WBCoreBundle:nav:index.html.twig', array(

            )
        );



    }



}
