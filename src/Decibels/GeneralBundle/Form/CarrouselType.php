<?php

namespace Decibels\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Decibels\GeneralBundle\Form\FileType;

class CarrouselType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('picture', 'fileUpload', array(
                 'label' => false
            ))
            ->add('zoom', 'hidden')
            ->add('ratio', 'hidden')
            ->add('leftClip', 'hidden')
            ->add('topClip', 'hidden');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Decibels\GeneralBundle\Entity\Carrousel',
            'attr' => ['id' => 'carrousel_form']
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'decibels_generalbundle_carrousel';
    }
}
