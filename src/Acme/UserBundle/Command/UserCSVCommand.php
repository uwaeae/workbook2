<?php

namespace Acme\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Acme\UserBundle\Entity\User;


class UserCSVCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this

            ->setName('import:user:file')
            ->setDescription('Users to Login')
            ->addArgument('file', InputArgument::OPTIONAL, ' CSV')//->addOption('EMail', null, InputOption::VALUE_NONE, 'E Mail Adress of the User')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $_import = array();


        if (($handle = fopen($input->getArgument('file'), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $_import[] = $data;
            }
            fclose($handle);
        } else {
            $output->writeln("Ein fehler ist Aufgetreten");
        }
        $factory = $this->getContainer()->get('security.encoder_factory');
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        foreach ($_import as $import) {

            $_user = $em->getRepository('AcmeUserBundle:User')->findOneByUsername($import[9]);
            if ($import[0] != 'email' and is_null($_user)) {
                $user = new User();
                $password = $this->generatePassword();
                $factory = $this->getContainer()->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
                $user->setUsername($import[9]);
                $user->setEmail($import[0]);
                $user->setFirstname($import[1]);
                $user->setLastname($import[2]);
                //$user->setStreet($import[9]);
                $user->setCity($import[5]);
                $user->setMobile($import[7]);
                $user->setTelephone($import[6]);
                //$user->setZip($import[10]);
                $user->setCountry($import[3]);
                $group = $this->getContainer()->get('doctrine')
                    ->getRepository('AcmeUserBundle:Group')->findOneByName('User');
                $user->addGroup($group);
                $region = $em->getRepository('AcmeUserBundle:Region')->find($import[8]);
                if ($region) $user->setRegion($region);
                if (strlen($import[1] > 2)) $_lang = substr($import[4], -2);
                else $_lang = $import[4];

                $lang = $em->getRepository('CTMTranslateBundle:Language')->findOneByIso2($_lang);
                if ($lang) $user->setLanguage($lang);
                $user->setDeleted(false);

                $em->persist($user);
                $em->flush();


                $message = \Swift_Message::newInstance()
                    ->setSubject('The new CTM tool is online!!!')
                    ->setFrom(array('ivonne.bierwirth@conti.de'=>'Ivonne Bierwirth'))
                    ->setTo($user->getEmail())
                    //->setTo('jan.westphal@iconnewmedia.de')
                    ->setBody("Dear {$user->getFirstname()},

I'm pleased to announce that our new ContiTireManagement system is now online!!

After having analysed your feedback regarding CTM tool some months ago, where some restrictions, limited flexibility and the need for more usability have been recognised.
Thank you for this feedback. It was more than helpful in order to integrate the improvements into the relaunch of ContiTireManagement.

We have a new web address to access the new CTM system.
(Don’t forget to add that one to your Favorite list)

Link: http://www.conti-ctm.com

Enter your login data as follows:

Username: {$user->getUsername()}
Password: {$password}


Please get familiar with the system that is intended to be more self-explaining, more intuitive, user-friendly and easier to use.

However we have prepared some training material for you as well.
Where to find that?
After you have logged in, go to HELP. There you will find a couple of little movies which will guide you through the tool.

I kindly ask you to update your own profile and enter all necessary data.
(This is a helpful step as your contact details will be taken over to the proposal, incl.picture).

The old CTM system will still be accessible for the next weeks. Please note that the old data will not be transferred to the new system. That’s why you have to save your proposals (pdf.files) locally on your laptop.

The further procedure will be as follows:
During the next days I will invite you for a telephone conference, which will take place in approx. two weeks. We will review your experiences with the new CTM tool, we can go through the system and you can address questions or remarks.

If you find out any difficulties, misunderstandings or bugs, please inform me directly.
In case of any questions or login problems, please don’t hesitate to contact me.

Best regards / mit freundlichen Grüßen

Ivonne Bierwirth
Marketing Communications/ New Media
BU Industrial Tires

Continental
Commercial Vehicle Tires Division

Billing address:
Continental Reifen Deutschland GmbH
Abt. 68014
Postfach 1 69
30001 Hannover
Germany

Telefon/Phone: +49 511 938 2298
Mobil: +49 151 43856914
Telefax: 0049 511 938-2706
E-Mail: ivonne.bierwirth@conti.de
");

                //$this->getContainer()->renderView('AcmeUserBundle:User:newuser.txt.twig', array(
                //'user' => $user,
                //'password' => $password
                //)));
                $this->getContainer()->get('mailer')->send($message);

            }

        }

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
    /*
        protected function interact(InputInterface $input, OutputInterface $output)
        {
            $dialog = $this->getDialogHelper();
            $dialog->writeSection($output, 'User Generator');




        }
    */

}

