<?php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class LangageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array('required' => true, 'label' => 'Nom :'))
                ->add('description', TextareaType::class, array('required' => true, 'label' => 'Description :'))
                ->add('temporary_image', FileType::class, array('required' => true, 'label' => 'Image (.jpg, .png, .gif) :', 'data_class' => null));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\Langage',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'langage_type_crsf'
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_langage';
    }


}
