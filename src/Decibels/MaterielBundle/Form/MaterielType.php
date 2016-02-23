<?php

namespace Decibels\MaterielBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MaterielType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('type')
            ->add('description')
            ->add('prix')
			->add('maxNum', null, array('label' => 'Quantité maximum'))
			->add('Enregistrer', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Decibels\MaterielBundle\Entity\Materiel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'decibels_materielbundle_materiel';
    }
}
