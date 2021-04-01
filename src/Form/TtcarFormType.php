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

class TtcarFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, array(
                'required' => true,
            ))
            ->add('number', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('adress', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('adress_city', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('adress_code', NumberType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('adress_country', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('email', TextType::class, array(
                'required' => true,
                'label' => false
            ))
            ->add('hours', TextType::class, array(
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
