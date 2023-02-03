<?php

namespace App\Form;

use App\Entity\Contract;
use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('company', TextType::class, [
                'label' => 'Entreprise',
                'help' => 'Renseignez le nom de l\'entreprise',
                'required' => false,
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Date de début',
                'years' => range(date('Y') - 50, date('Y')),
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Date de fin',
                'required' => false,
                'years' => range(date('Y') - 50, date('Y')),
                'widget' => 'single_text',
            ])
            ->add('isCurrentPosition', CheckboxType::class, [
                'label' => 'Poste actuel',
                'required' => false,
                'label_attr' => ["class" => "fs-5"]
            ])
            ->add('contract', EntityType::class, [
                'class' => Contract::class,
                'choice_label' => 'name',
                'label' => 'Type de contrat',
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => 'form-select my-2 '],
                'help' => 'Sélectionnez le type de contrat',
                'required' => false,
            ])
            ->add('jobTitle', TextType::class, [
                'label' => 'Intitulé du poste',
                'help' => 'Renseignez le nom du poste occupé',
                'required' => false,
            ])
            ->add('jobDescription', TextareaType::class, [
                'label' => 'Description',
                'help' => 'Donnez une description de votre expérience',
                'attr' => ["rows" => "3"],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
