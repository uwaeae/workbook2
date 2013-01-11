<?php

namespace Acme\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserShow extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('street')
            ->add('zip')
            ->add('city')
            ->add('country','country',array('required'=>false,'label'  => 'proposal.form.country',))
            ->add('telephone')
            ->add('mobile')
            ->add('fax')
            ->add('file',new \CTM\DownloadBundle\Form\FileType(),array('required' => false))
            ->add('Language')
            ->add('currency')
            ->add('password','password')
            ->add('passwordrepeat' , 'password')
        ;
    }

    public function getName()
    {
        return 'acme_userbundle_usershow';
    }
}
