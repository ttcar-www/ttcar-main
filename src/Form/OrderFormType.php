<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Mark;
use App\Entity\Nationality;
use App\Entity\Reason;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, array(
                'required' => true,
            ))
            ->add('email', EmailType::class,
                [
                    "label"=>"form_order.email",
                    'translation_domain' => 'messages'
                ]
            )
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please choice a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('customer_type', ChoiceType::class, [
                'choices' => [
                    'form_order.typeMr' => 'mr',
                    'form_order.typeMme' => 'mme',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => false
            ])
            ->add('customer_name', TextType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('customer_old_name', TextType::class, array(
                'required' => false,
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('customer_username', TextType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('adress', TextType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('city', TextType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('postal_code', NumberType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'getNameFr',
                'expanded' => false,
                'multiple' => false,
                "label"=>false,
                'translation_domain' => 'messages'
            ])
            ->add('phone', TelType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('profession', TextType::class, array(
                "label"=>false
            ))
            ->add('nationality', EntityType::class, [
                'class' => Nationality::class,
                'choice_label' => 'getNameFr',
                'expanded' => false,
                'multiple' => false,
                "label"=>false,
                'translation_domain' => 'messages'
            ])
            ->add('birth_date', DateType::class, array(
                "label"=>false,
                'translation_domain' => 'messages',
                'widget' => 'single_text'
            ))
            ->add('birth_postal', NumberType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('birth_city', TextType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('birth_country', TextType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('passport_number', NumberType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('passport_date', DateType::class, array(
                "label"=>false,
                'translation_domain' => 'messages',
                'widget' => 'single_text'
            ))
            ->add('passport_place', TextType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('number_plane', TextType::class, [
                "label"=>false,
                'translation_domain' => 'messages'
            ])
            ->add('planeDate2', TimeType::class, [
                'input'  => 'string',
                'widget' => 'single_text',
                "label"=>false,
                'translation_domain' => 'messages',
                'with_seconds' => false
            ])
            ->add('place_plane', TextType::class, array(
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('reason', EntityType::class, [
                'class' => Reason::class,
                'choice_label' => 'getContent',
                'expanded' => false,
                'multiple' => false,
                "label"=>false,
                'translation_domain' => 'messages'
            ])
            ->add('adress_city_hue', TextType::class, array(
                'required' => false,
                "label"=>false,
                'translation_domain' => 'messages'
            ))

            ->add('adress_country_hue', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'getNameFr',
                'expanded' => false,
                'multiple' => false,
                "label"=>false,
                'translation_domain' => 'messages'
            ])
            ->add('adress_no_ue', TextType::class, array(
                'required' => false,
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('adress_code_hue', NumberType::class, array(
                'required' => false,
                "label"=>false,
                'translation_domain' => 'messages'
            ))
            ->add('comment', TextareaType::class, array(
                "label"=> false,
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
