<?php

namespace App\Form;

use App\Entity\Mark;
use App\Entity\Place;
use App\Entity\PlaceExtra;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mark', EntityType::class, [
                'class' => Mark::class,
                'choice_label' => 'getLibelle',
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])
            ->add('placeDepart', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'getLibelle',
                'expanded' => false,
                'multiple' => false,
                'placeholder' => '(Choisir une marque)',
                'required' => false,
                'attr' => ['class' => 'placeDepart']
            ])
            ->add('date_start', DateType::class, array(
                'widget' => 'single_text',
                'label' => false,
                'html5' => false,
                'attr' => ['class' => 'datepicker-dateStart'],
                'format' => 'dd/MM/yyyy'
            ))
            ->add('placeReturn', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'getLibelle',
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Département (Choisir une marque)',
                'required' => false,
                'attr' => ['class' => 'placeDepart']
            ])
            ->add('date_end', DateType::class, array(
                'widget' => 'single_text',
                'label' => false,
                'html5' => false,
                'attr' => ['class' => 'datepicker-dateEnd'],
                'format' => 'dd/MM/yyyy'
            ))
            ->add('promo', NumberType::class, array(
                'label' => 'promo',
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
