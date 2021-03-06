<?php

namespace Decibels\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'Titre',
                'label_attr' => array("class" => "hidden"),
                'attr' => array(
                    'placeholder' => "Titre"
                )
            ))
            ->add('text', 'textarea', array(
                'label' => 'Contenu',
                'label_attr' => array("class" => "hidden"),
                'attr' => array(
                    'placeholder' => "Contenu",
                    "rows" => 10
                )
            ))
            ->add('picture', 'fileUpload', array('label' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Decibels\NewsBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'decibels_newsbundle_news';
    }
}
