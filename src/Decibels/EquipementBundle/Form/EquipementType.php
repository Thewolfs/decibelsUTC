<?php

namespace Decibels\EquipementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EquipementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, array(
                "label" => "Modèle",
                "label_attr" => array("class" => "hidden"),
                "attr" => array(
                    "placeholder" => "Modèle"
                )
            ))
            ->add('type', null, array(
                "label" => "Type (Enceinte, Micro, etc.)",
                "label_attr" => array("class" => "hidden"),
                "attr" => array(
                    "placeholder" => "Type (Enceinte, Micro, etc.)"
                )
            ))
            ->add('description', null, array(
                "label" => "Description",
                "label_attr" => array("class" => "hidden"),
                "attr" => array(
                    "placeholder" => "Description",
                    "rows" => 10
                )
            ))
            ->add('prix', null, array(
                "label" => "Caution",
                "label_attr" => array("class" => "hidden"),
                "attr" => array(
                    "placeholder" => "Caution"
                )
            ))
			->add('maxNum', null, array(
                "label" => "Quantité maximum louable",
                "label_attr" => array("class" => "hidden"),
                "attr" => array(
                    "placeholder" => "Quantité maximum louable"
                )
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
            'data_class' => 'Decibels\EquipementBundle\Entity\Equipement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'decibels_equipementbundle_equipement';
    }
}
