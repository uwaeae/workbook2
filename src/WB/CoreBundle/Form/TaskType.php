<?php

namespace WB\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start')
            ->add('end')
            ->add('scheduled')
            ->add('break')
            ->add('overtime')
            ->add('info')
            ->add('approach')
            ->add('correctionTime')
            ->add('correctionInfo')
            ->add('createdAt')
            ->add('createdFrom')
            ->add('updatedAt')
            ->add('updatedFrom')
            ->add('user')
            ->add('job')
            ->add('taskType')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\CoreBundle\Entity\Task'
        ));
    }

    public function getName()
    {
        return 'wb_corebundle_tasktype';
    }
}
