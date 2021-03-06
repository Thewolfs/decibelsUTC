<?php

namespace Decibels\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrainingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', null, array(
                'label' => 'Titre de la formation',
                'label_attr' => array("class" => 'hidden'),
                'attr' => array(
				    'placeholder' => 'Titre de la formation'
			    )
            ))
            ->add('description', null, array(
                'label' => 'Description',
                'label_attr' => array("class" => 'hidden'),
                'attr' => array(
                    'placeholder' => 'Description de la formation',
                    'rows' => 5
			    )
            ))
            ->add('type', 'choice', array(
                'label' => 'Pôle',
				'choices'  => array(
					'Sono' => 0,
					'Light' => 1,
					'MAO' => 2,
				),
				'choices_as_values' => true,
				'label' => false,
			))
            ->add('file', 'fileUpload')
			->add('Ajouter', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Decibels\TrainingBundle\Entity\Training'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'decibels_formationbundle_formation';
    }
}
