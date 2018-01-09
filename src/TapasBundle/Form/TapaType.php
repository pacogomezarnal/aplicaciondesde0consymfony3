<?php

namespace TapasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TapaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nombre',TextType::class,  array('attr' => array('class' => 'form-control')))
        ->add('descripcion',TextareaType::class,  array('attr' => array('class' => 'form-control')))
        ->add('ingredientes',CKEditorType::class, array('config_name' => 'my_config_1'))
        ->add('foto', FileType::class,array('attr' => array('onchange' => 'onChange(event)')))
        ->add('fechaCreacion',DateType::class)
        ->add('top')
        ->add('Guardar',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TapasBundle\Entity\Tapa'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tapasbundle_tapa';
    }


}
