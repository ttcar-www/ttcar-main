<?php

namespace App\Form;

use App\Entity\Place;
use App\Entity\Range;
use App\Entity\TypePromo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PromotionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, array(
                'required' => true,
            ))
            ->add('libelle', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('description', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('value', NumberType::class, array(
                'label' => false
            ))
            ->add('start_date', DateType::class, array(
                'label' => false
            ))
            ->add('end_date', DateType::class, array(
                'label' => false
            ))
            ->add('start_delivery', DateType::class, array(
                'label' => false
            ))
            ->add('end_delivery', DateType::class, array(
                'label' => false
            ))
            ->add('place_delivery', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'getLibelle',
                'expanded' => true,
                'multiple' => false,
                'label' => false
            ])
            ->add('place_departure', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'getLibelle',
                'expanded' => true,
                'multiple' => false,
                'label' => false
            ])
            ->add('type', EntityType::class, [
                'class' => TypePromo::class,
                'choice_label' => 'getType',
                'expanded' => true,
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
