<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company', TextType::class, [
                'label' => 'Entreprise',
                'help' => 'Renseignez le nom de l\'entreprise',
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Date de début',
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Date de fin',
                'required' => false,
            ])
            ->add('isCurrentPosition', CheckboxType::class, [
                'label' => 'Poste actuel',
                'required' => false,
                'label_attr' => ["class" => "fs-5"]
            ])
            ->add('jobTitle', TextType::class, [
                'label' => 'Intitulé du poste',
                'help' => 'Renseignez le nom de l\'entreprise',
            ])
            ->add('jobDescription', TextareaType::class, [
                'label' => 'Description',
                'help' => 'Donnez une description de votre expérience',
                'attr' => ["rows" => "3"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
