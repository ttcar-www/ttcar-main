<?php

namespace App\Form;

use App\Entity\Mark;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class OrderSimpleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, array(
                'required' => true,
            ))
            ->add('number_plane', TextType::class, [
                "label"=>"form_order.numberPlane",
                'translation_domain' => 'messages'
            ])
            ->add('planeDate2', TimeType::class, [
                'input'  => 'string',
                'widget' => 'single_text',
                "label"=>"form_order.planeDate",
                'translation_domain' => 'messages',
                'with_seconds' => false
            ])
            ->add('place_plane', TextType::class, array(
                "label"=>"form_order.placePlane",
                'translation_domain' => 'messages'
            ))
            ->add('comment', TextareaType::class, array(
                "label"=>false,
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
