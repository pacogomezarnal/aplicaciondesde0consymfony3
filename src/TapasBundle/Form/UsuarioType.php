<?php

namespace TapasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UsuarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nombre',TextType::class,  array('attr' => array('class' => 'form-control')))
        ->add('apellidos',TextType::class,  array('attr' => array('class' => 'form-control')))
        ->add('telefono',TextType::class,  array('attr' => array('class' => 'form-control')))
        ->add('email',EmailType::class,  array('attr' => array('class' => 'form-control')))
        ->add('plainPassword', RepeatedType::class, array(
              'label' => 'Contraseña',
              'type' => PasswordType::class,
              'first_options'  => array('label' => 'Password','attr' => array('class' => 'form-control')),
              'second_options' => array('label' => 'Repite Password','attr' => array('class' => 'form-control')),
          ))
        ->add('Registrar',SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TapasBundle\Entity\Usuario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tapasbundle_usuario';
    }


}
