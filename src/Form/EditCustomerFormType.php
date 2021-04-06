<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Customer;

use App\Entity\Nationality;
use App\Entity\Reason;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditCustomerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('username', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('name_young', TextType::class, array(
                'required' => false,
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('adress_ue', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('adress_no_ue', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('profession', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('birthdays_date', DateType::class, array(
                'widget' => 'single_text',
                'required' => true,
                'label' => false
            ))
            ->add('country_birth', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('birth_postal', NumberType::class, array(
                'label' => 'birth postal'
            ))
            ->add('nationality', EntityType::class, [
                'class' => Nationality::class,
                'choice_label' => 'getNameFr',
                'expanded' => false,
                'multiple' => false,
                "label"=>"form_order.nationality",
                'translation_domain' => 'messages'
            ])
            ->add('customer_type', ChoiceType::class, [
                'choices' => [
                    'Mr' => 'mr',
                    'Mme' => 'mme',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => false
            ])
            ->add('pice_identity', ChoiceType::class, [
                'choices' => [
                    'Passport' => 'Passport',
                    'Carte identité' => 'ci'
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => false
            ])
            ->add('number_piece', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('adress_code', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('adress_code_hue', NumberType::class, array(
                'required' => false,
                'label' => false
            ))
            ->add('delivery_piece', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('adress_city', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('adress_country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'getNameFr',
                'expanded' => false,
                'multiple' => false,
                "label"=>"form_order.country",
                'translation_domain' => 'messages'
            ])
            ->add('adress_city_hue', TextType::class, array(
                'required' => false,
                'label' => false
            ))
            ->add('adress_country_hue', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'getNameFr',
                'expanded' => false,
                'multiple' => false,
                "label"=>"form_order.adressCountryHue",
                'translation_domain' => 'messages'
            ])
            ->add('date_piece', DateType::class, array(
                'widget' => 'single_text',
                'required' => true,
                'label' => false
            ))
            ->add('reason', EntityType::class, [
                'class' => Reason::class,
                'choice_label' => 'getContent',
                'expanded' => false,
                'multiple' => false,
                "label"=>"form_order.reason",
                'translation_domain' => 'messages'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Customer::class,
        ));
    }
}
