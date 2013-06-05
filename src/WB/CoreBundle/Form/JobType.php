<?php

namespace WB\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WB\CoreBundle\Form\DataTransformer\AddressToNumberTransformer;


class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['em'];
        $transformer = new AddressToNumberTransformer($entityManager);
        $builder
            ->add('contactPerson')
            ->add('contactInfo')
            ->add('end')
            ->add('start')
            ->add('Address','hidden')
           /* ->add($builder->create('Address', 'hidden')
                ->addModelTransformer($transformer)
            )*/
            ->add('description')
            ->add('jobType',null,array(
                'empty_value' => false,
                'data' => '1'))
         //   ->add('jobState','hidden',array(
         //       'data' => '1'))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\CoreBundle\Entity\Job'
        ));
        $resolver->setRequired(array(
            'em',
        ));

        $resolver->setAllowedTypes(array(
            'em' => 'Doctrine\Common\Persistence\ObjectManager',
        ));

    }

    public function getName()
    {
        return 'wb_corebundle_jobtype';
    }
}
