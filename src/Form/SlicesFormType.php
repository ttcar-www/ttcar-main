<?php

namespace App\Form;

use App\Entity\Mark;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

class SlicesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, array(
                'required' => true,
            ))
            ->add('code_price', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('days_min', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('days_max', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('value', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('type', ChoiceType::class, [
                'choices' => [
                    '%' => '%',
                    '€' => '€',
                    'jours' => 'jours'
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])
            ->add('operators', ChoiceType::class, [
                'choices' => [
                    'Inférieur' => '<',
                    'Inférieur ou égal' => '=<',
                    'Supérieur' => '>',
                    'Supérieur ou égal' => '≥'
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])
            ->add('days', NumberType::class, array(
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
