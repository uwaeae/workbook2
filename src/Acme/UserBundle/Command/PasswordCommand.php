<?php

namespace Acme\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Acme\UserBundle\Entity\User;


class PasswordCommand extends ContainerAwareCommand
{
protected function configure()
{
    $this

        ->setName('security:password:reset')
        ->setAliases(array('generate:security:user'))
        ->setDescription('Set a New Password')
        ->addArgument('Email', InputArgument::OPTIONAL, 'Email')
        ->addArgument('pw', InputArgument::OPTIONAL, 'password ')

        //->addOption('EMail', null, InputOption::VALUE_NONE, 'E Mail Adress of the User')
        ;
}

protected function execute(InputInterface $input, OutputInterface $output)
    {

        //$output->writeln("You type:");
        //$output->writeln(" EMail : ".$input->getOption('Email')." Passwort: ".$input->getOption("pw"));

        $factory = $this->getContainer()->get('security.encoder_factory');
        $user = $this->getContainer()->get('doctrine')
            ->getRepository('AcmeUserBundle:User')->findOneByEmail($input->getArgument('Email'));
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($input->getArgument('pw'), $user->getSalt());
        $user->setPassword($password);
        //$user->setUsername($input->getArgument('Username'));
        //$user->setEmail($input->getArgument('Email'));

        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $em->persist($user);
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

