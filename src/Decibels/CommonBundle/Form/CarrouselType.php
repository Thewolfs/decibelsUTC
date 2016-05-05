<?php

namespace Decibels\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Decibels\CommonBundle\Form\FileType;

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
            ->add('leftClip', 'hidden')
            ->add('topClip', 'hidden');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Decibels\CommonBundle\Entity\Carrousel',
            'attr' => array('id' => 'carrousel_form')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'decibels_commonbundle_carrousel';
    }
}
