<?php

namespace App\Form;

use App\Entity\Accessory;
use App\Entity\Mark;
use App\Entity\Range;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\File;

class CarsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, array(
                'required' => true,
            ))
            ->add('name', TextType::class, array(
                'label' => false
            ))
            ->add('items', EntityType::class, [
                'class' => Accessory::class,
                'choice_label' => 'getLibelle',
                'expanded' => true,
                'multiple' => true,
                'label' => false
            ])
            ->add('margin', NumberType::class, array(
                'label' => false
            ))
            ->add('minDays', NumberType::class, array(
                'label' => false
            ))
            ->add('date_start', DateType::class, array(
                'label' => false,
                'widget' => 'single_text'
            ))
            ->add('date_end', DateType::class, array(
                'label' => false,
                'widget' => 'single_text'
            ))
            ->add('fuel', ChoiceType::class, [
                'choices' => [
                    'Essence' => 'essence',
                    'Diesel' => 'diesel',
                    'Hybride' => 'hybride',
                    'Electrique' => "electrique"
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])
            ->add('roofRack', NumberType::class, array(
                'label' => false
            ))
            ->add('chains', NumberType::class, array(
                'label' => false
            ))
            ->add('years', NumberType::class, array(
                'label' => false
            ))
            ->add('sellingPrice', NumberType::class, array(
                'label' => false
            ))
            ->add('passenger', NumberType::class, array(
                'label' => false
            ))
            ->add('door', NumberType::class, array(
                'label' => false
            ))
            ->add('co2', NumberType::class, array(
                'label' => false
            ))
            ->add('clim', ChoiceType::class, [
                'choices' => [
                    'Oui' => '1',
                    'Non' => '0'
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => false
            ])
            ->add('contactActived', ChoiceType::class, [
                'choices' => [
                    'Oui' => '1',
                    'Non' => '0'
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => false
            ])
            ->add('transmission', TextType::class, array(
                'label' => false
            ))
            ->add('luggage', NumberType::class, array(
                'label' => false
            ))
            ->add('carImg', FileType::class, [
                'label' => false,

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            "image/jpeg",
                            "image/png",
                            "image/gif",
                            "image/jpg"
                        ],
                        'mimeTypesMessage' => 'Please upload a valid img document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
