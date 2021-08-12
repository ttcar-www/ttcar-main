<?php

namespace App\Form;

use App\Entity\Mark;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditExtraPlaceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand_id', EntityType::class, [
                'class' => Mark::class,
                'choice_label' => 'getLibelle',
                'expanded' => true,
                'multiple' => false,
                'label' => false
            ])
            ->add('extra_1', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('extra_2', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('days_limit', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
