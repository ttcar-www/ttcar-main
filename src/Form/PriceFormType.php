<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PriceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, array(
                'required' => true,
            ))
            ->add('libelle', ChoiceType::class, [
                'choices' => [
                    'Prix référence de base' => '1',
                    'Prix net agent' => '2'
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])
            ->add('price', NumberType::class, array(
                'label' => false
            ))
            ->add('date_start', DateType::class, array(
                'label' => false
            ))
            ->add('date_end', DateType::class, array(
                'label' => false
            ))
            ->add('date_start_delivery', DateType::class, array(
                'label' => false
            ))
            ->add('date_end_delivery', DateType::class, array(
                'label' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
