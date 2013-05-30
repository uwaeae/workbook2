<?php

namespace WB\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number')
            ->add('contact')
            ->add('info')
            ->add('street')
            ->add('city')
            ->add('country')
            ->add('destrict')
            ->add('fon')
            ->add('fax')
            ->add('postcode')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('customer')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\CoreBundle\Entity\Address'
        ));
    }

    public function getName()
    {
        return 'wb_corebundle_addresstype';
    }
}
