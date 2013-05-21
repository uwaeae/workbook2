<?php

namespace WB\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contactPerson')
            ->add('contactInfo')
            ->add('end')
            ->add('start')
            ->add('timeed')
            ->add('description')
            ->add('timeinterval')
            ->add('createdAt')
            ->add('createdFrom')
            ->add('updatedAt')
            ->add('updatedFrom')
            ->add('file')
            ->add('invoice')
            ->add('jobState')
            ->add('jobType')
            ->add('Address')
            ->add('user')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\CoreBundle\Entity\Job'
        ));
    }

    public function getName()
    {
        return 'wb_corebundle_jobtype';
    }
}
