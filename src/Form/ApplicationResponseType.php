<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ApplicationResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('ApplicationStatus', ChoiceType::class, [
            'choices' => [
                'En cours' => Application::APPLICATION_STATUS['IN_PROGRESS'],
                'Acceptée' => Application::APPLICATION_STATUS['ACCEPTED'],
                'Refusée' => Application::APPLICATION_STATUS['REJECTED'],
            ],
            'label' => 'Statut',
            'help' => 'Choisir et soumettre',
        ])
            ->add('Soumettre', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
