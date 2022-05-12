<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class, array(
                'required' => true,
            ))
            ->add('email', EmailType::class, array(
                'label' => false
                ))
            ->add('username', TextType::class, array(
                'label' => false
            ))
            ->add('password', RepeatedType::class, array(
                'label' => false,
                'type' => PasswordType::class,
                'first_options'  => array('label' => false),
                'second_options' => array('label' => false),
            ))
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Client' => 'ROLE_CUSTOMER',
                    'Commercial' => 'ROLE_COM',
                    'Admin' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}