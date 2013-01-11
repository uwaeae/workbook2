<?php

namespace Acme\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('firstname')
            ->add('lastname')
            ->add('email','email')
            ->add('street')
            ->add('zip')
            ->add('city')
            ->add('country','country',array('required'=>false,'label'  => 'proposal.form.country',))
            ->add('telephone')
            ->add('mobile')
            ->add('fax')
            ->add('file',new \CTM\DownloadBundle\Form\FileType(),array('required' => false))
            ->add('password','password')
            ->add('passwordrepeat','password')
            ->add('isActive')
            ->add('groups')
            ->add('Region')
            ->add('Language')
            ->add('currency')
        ;
    }

    public function getName()
    {
        return 'acme_userbundle_usertype';
    }
}
