<?php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use MainBundle\Form\IllustrationType;
use MainBundle\Form\PDFType;
use MainBundle\Form\SourceType;

class ProjetType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nom', TextType::class, array('required' => true, 'label' => 'Nom :'))
                ->add('resume', TextareaType::class, array('required' => true, 'label' => 'Résumer :'))
                ->add('illustrations', CollectionType::class, array('label' => 'Illustrations :', 'entry_type' => IllustrationType::class, 'allow_add' => true, 'prototype' => true, 'by_reference' => false))
                ->add('technologies', EntityType::class, array('required' => true,'label' => 'Langage utilisé :', 'class' => 'MainBundle:Technologie', 'choice_label' => 'nom', 'multiple' => true))
                ->add('langages', EntityType::class, array('required' => true,'label' => 'Langage utilisé :', 'class' => 'MainBundle:Langage', 'choice_label' => 'nom', 'multiple' => true))
                ->add('pdf', PDFType::class)
                ->add('source', SourceType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\Projet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'mainbundle_projet';
    }

}
