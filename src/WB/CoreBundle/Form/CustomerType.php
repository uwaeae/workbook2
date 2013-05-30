<?php

namespace WB\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company')
            ->add('logo')
            ->add('url')
            ->add('number')
            ->add('headoffice')

                    ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\CoreBundle\Entity\Customer'
        ));
    }

    public function getName()
    {
        return 'wb_corebundle_customertype';
    }
}
