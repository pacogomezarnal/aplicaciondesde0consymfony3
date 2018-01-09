<?php

namespace TapasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('cliente',TextType::class,array('mapped' => false,'data'=>$options['cliente'],'label'=>'Numero telefono cliente','attr' => array('class' => 'form-control','readonly' => 'true')))
        ->add('fecha',DateType::class)
        ->add('numPersonas',IntegerType::class,  array('attr' => array('class' => 'form-control')))
        ->add('observaciones',TextareaType::class,  array('attr' => array('class' => 'form-control')))
        ->add('Reservar',SubmitType::class,  array('attr' => array('class' => 'form-btn btn-primary')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TapasBundle\Entity\Reserva',
            'cliente'=>''
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tapasbundle_reserva';
    }


}
