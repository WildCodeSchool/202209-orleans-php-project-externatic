<?php

namespace App\Form;

use App\Entity\Education;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EducationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('school', TextType::class, [
                'label' => 'Établissement',
                'help' => 'Renseignez le nom de l\'établissement',
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Date de début',
                'years' => range(date('Y') - 50, date('Y')),
                'widget' => 'single_text',
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Date de fin',
                'required' => false,
                'years' => range(date('Y') - 50, date('Y')),
                'widget' => 'single_text',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'help' => 'Donnez une description de votre formation',
                'attr' => ["rows" => "3"]
            ])
            ->add('title', TextType::class, [
                'label' => 'Intitulé de la formation',
                'help' => 'Renseignez le nom de la formation',
            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Diplôme',
                'choices'  => [
                    'BEP' => 'BEP',
                    'CAP' => 'CAP',
                    'BAC' => 'BAC',
                    'BAC+2' => 'BAC+2',
                    'BAC+4' => 'BAC+4',
                    'BAC+5' => 'BAC+5',
                    'BAC+8' => 'BAC+8',
                    'BAC+10' => 'BAC+10',
                    'BAC+12' => 'BAC+12',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Education::class,
        ]);
    }
}
