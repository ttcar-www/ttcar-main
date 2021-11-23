<?php

namespace App\Form;

use App\Entity\Mark;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('brand', ChoiceType::class, [
                'choices' => [
                    'Renault' => '1',
                    'PSA' => '2'
                ],
                'expanded' => true,
                'mapped' => false,
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
            ->add('free', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false
                ],
                'expanded' => true,
                'data' => false,
                'multiple' => false,
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
