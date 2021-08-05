<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EditPlaceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('libelle_en', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('latitude', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('longitude', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('full_adress_fr', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('full_adress_en', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('price', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('placePDF', FileType::class, [
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
                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid pdf document',
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
