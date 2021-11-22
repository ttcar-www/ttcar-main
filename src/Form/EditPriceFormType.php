<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditPriceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', ChoiceType::class, [
                'choices' => [
                    'Prix Client' => '1',
                    'Prix Fournisseur' => '2'
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])
            ->add('price', NumberType::class, array(
                'label' => false
            ))
            ->add('priceSupplierValue', NumberType::class, array(
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
            ->add('date_start_delivery', DateType::class, array(
                'label' => false,
                'widget' => 'single_text'
            ))
            ->add('date_end_delivery', DateType::class, array(
                'label' => false,
                'widget' => 'single_text'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
