<?php

namespace Acme\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Acme\UserBundle\Entity\User;


class UserCommand extends ContainerAwareCommand
{
protected function configure()
{
    $this

        ->setName('security:generate:user')
        ->setAliases(array('generate:security:user'))
        ->setDescription('Create a User to Login')
        ->addArgument('Email', InputArgument::OPTIONAL, ' Email')
        ->addArgument('Username', InputArgument::OPTIONAL, 'Username')
        ->addArgument('pw', InputArgument::OPTIONAL, 'pw ')
        ->addArgument('Firstname', InputArgument::OPTIONAL, ' Firstname')
        ->addArgument('Lastname', InputArgument::OPTIONAL, ' Lastname')

        //->addOption('EMail', null, InputOption::VALUE_NONE, 'E Mail Adress of the User')
        ;
}

protected function execute(InputInterface $input, OutputInterface $output)
    {

        //$output->writeln("You type:");
        //$output->writeln(" EMail : ".$input->getOption('Email')." Passwort: ".$input->getOption("pw"));

        $factory = $this->getContainer()->get('security.encoder_factory');
        $user = new User();
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($input->getArgument('pw'), $user->getSalt());
        $user->setPassword($password);
        $user->setUsername($input->getArgument('Username'));
        $user->setEmail($input->getArgument('Email'));
        $user->setFirstname($input->getArgument('Firstname'));
        $user->setLastname($input->getArgument('Lastname'));
        $user->setDeleted(false);
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $lang = $em->getRepository('CTMTranslateBundle:Language')->find(1);
        $user->setLanguage($lang);
        $currency = $em->getRepository('CTMProposalBundle:Currency')->find(1);
        $user->setCurrency($currency);

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

