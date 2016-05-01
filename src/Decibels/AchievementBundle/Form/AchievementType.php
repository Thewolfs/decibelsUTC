<?php

namespace Decibels\AchievementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AchievementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, array(
                "label" => "Nom",
                "label_attr" => array('class' => 'hidden'), 
                "attr" => array(
                    "placeholder" => "Nom"
                )
            ))
            ->add('description', null, array(
                "label" => "Description",
                "label_attr" => array('class' => 'hidden'), 
                "attr" => array(
                    "placeholder" => "Description",
                    "rows" => '10'
                )
            ))
            ->add('url', null, array(
                "label" => "Lien vers la réalisation (Soundcloud si MAO)",
                "label_attr" => array('class' => 'hidden'), 
                "attr" => array(
                    "placeholder" => "Lien vers la réalisation (Soundcloud si MAO)"
                )
            ))
            ->add('event', 'choice', array(
                'choices'  => array(
					'Oui' => 1,
					'Non' => 0
				),
				'choices_as_values' => true,
                "label" => "Est-ce un évènement live ?"
            ))
			->add('Enregistrer', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Decibels\AchievementBundle\Entity\Achievement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'decibels_realisationbundle_realisation';
    }
}
