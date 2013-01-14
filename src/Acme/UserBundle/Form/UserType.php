<?php

namespace Acme\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('username')
            ->add('isActive')
            ->add('password','password')
            ->add('passwordrepeat' , 'password')
            ->add('isSuperAdmin')
            ->add('groups')
            ->add('permission')
            ->add('Company')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'acme_userbundle_usertype';
    }
}
