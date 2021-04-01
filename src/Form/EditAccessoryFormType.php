<?php

namespace App\Form;

use App\Entity\Mark;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EditAccessoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('year', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('price', NumberType::class, array(
                'label' => false
            ))
            ->add('mark', EntityType::class, [
                'class' => Mark::class,
                'choice_label' => 'getLibelle',
                'multiple' => false
            ])
            ->add('itemImg', FileType::class, [
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
