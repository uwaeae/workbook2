<?php

namespace Acme\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Acme\UserBundle\Entity\Group;


class GroupCommand extends ContainerAwareCommand
{
protected function configure()
{
    $this

        ->setName('security:generate:group')
        ->setAliases(array('generate:security:group'))
        ->setDescription('Create a Group ')
        ->addArgument('Name', InputArgument::OPTIONAL, 'Name')
        ->addArgument('Role', InputArgument::OPTIONAL, 'Role')


        //->addOption('EMail', null, InputOption::VALUE_NONE, 'E Mail Adress of the User')
        ;
}

protected function execute(InputInterface $input, OutputInterface $output)
    {

        //$output->writeln("You type:");
        //$output->writeln(" EMail : ".$input->getOption('Email')." Passwort: ".$input->getOption("pw"));

        $group = new Group();


        $group->setName($input->getArgument('Name'));
        $group->setRole($input->getArgument('Role'));
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $em->persist($group);
        $em->flush();


    }

/*
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        $dialog->writeSection($output, 'User Generator');




    }
*/

}

