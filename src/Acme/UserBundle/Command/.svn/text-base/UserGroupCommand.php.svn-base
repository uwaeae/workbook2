<?php

namespace Acme\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Acme\UserBundle\Entity\Group;


class UserGroupCommand extends ContainerAwareCommand
{
protected function configure()
{
    $this

        ->setName('security:add:user-group')
        ->setDescription('Add a User to a Group ')
        ->addArgument('Username', InputArgument::OPTIONAL, 'Username')
        ->addArgument('Group',null, 'Group')

        //->addOption('EMail', null, InputOption::VALUE_NONE, 'E Mail Adress of the User')
        ;
}

protected function execute(InputInterface $input, OutputInterface $output)
    {

        //$output->writeln("You type:");
        //$output->writeln(" EMail : ".$input->getOption('Email')." Passwort: ".$input->getOption("pw"));
        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        $user = $this->getContainer()->get('doctrine')
            ->getRepository('AcmeUserBundle:User')->findOneByUsername($input->getArgument('Username'));
        $group = $this->getContainer()->get('doctrine')
            ->getRepository('AcmeUserBundle:Group')->findOneByName($input->getArgument('Group'));

        if($user AND $group){
            $user->addGroup($group);
            $em->persist($user);
            $em->flush();

        }
        else {
            $output->writeln("An Error Occurred: I can´t find the User or the Group. \n ");
            $groups = $this->getContainer()->get('doctrine')
                ->getRepository('AcmeUserBundle:Group')->findAll();
            $output->writeln(" Posible Groups are: ");
            foreach($groups as $g){
                $output->writeln("  ".$g->getName());
            }

            $users = $this->getContainer()->get('doctrine')
                ->getRepository('AcmeUserBundle:User')->findAll();

            $output->writeln("Posible Users are: ");
            foreach($users as $u){
                $output->writeln("  ".$u->getUsername());
            }

        }

    }

/*
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        $dialog->writeSection($output, 'User Generator');




    }
*/

}

