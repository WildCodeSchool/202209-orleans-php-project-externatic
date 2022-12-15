<?php

namespace App\Form;

use App\Form\UserType;
use App\Entity\Candidate;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserType::class, [
                'label' => false
            ])
            ->add('nationality', CountryType::class, [
                'label' => 'Nationalité',
                'label_attr' => ['class' => 'font-subtitle'],
                'required' => true,
                'attr' => ['class' => 'tinymce',],
                'help' => 'Renseignez votre nationalité dans la liste',
                'help_attr' => ['class' => 'text-dark ',],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'label_attr' => ['class' => 'font-subtitle'],
                'required' => false,
                'attr' => ['class' => 'tinymce',],
                'help' => 'Renseignez votre adresse',
                'help_attr' => ['class' => 'text-dark ',],
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal',
                'label_attr' => ['class' => 'font-subtitle'],
                'required' => true,
                'attr' => ['class' => 'tinymce',],
                'help' => 'Renseignez votre code postal',
                'help_attr' => ['class' => 'text-dark ',],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'label_attr' => ['class' => 'font-subtitle'],
                'required' => true,
                'attr' => ['class' => 'tinymce',],
                'help' => 'Renseignez votre ville',
                'help_attr' => ['class' => 'text-dark ',],
            ])
            ->add('hobby', TextType::class, [
                'label' => 'Centre d\'intérêts',
                'label_attr' => ['class' => 'font-subtitle'],
                'required' => true,
                'attr' => ['class' => 'tinymce',],
                'help' => 'Renseignez vos centres d\'intérêts',
                'help_attr' => ['class' => 'text-dark ',],
            ])
            ->add('about_me', TextareaType::class, [
                'label' => 'À propose de moi',
                'label_attr' => ['class' => 'font-subtitle'],
                'required' => true,
                'attr' => ['class' => 'tinymce', "rows" => "3"]
            ])
            ->add('github', UrlType::class, [
                'label' => 'Github',
                'label_attr' => ['class' => 'font-subtitle'],
                'required' => false,
                'attr' => ['class' => 'tinymce',],
                'help' => 'Renseignez votre lien github',
                'help_attr' => ['class' => 'text-dark ',],
            ])
            ->add('linkedin', UrlType::class, [
                'label' => 'LinkedIn',
                'label_attr' => ['class' => 'font-subtitle'],
                'required' => false,
                'attr' => ['class' => 'tinymce',],
                'help' => 'Renseignez votre lien linkedIn',
                'help_attr' => ['class' => 'text-dark ',],
            ])
            ->add('portfolio', UrlType::class, [
                'label' => 'Portfolio',
                'label_attr' => ['class' => 'font-subtitle'],
                'required' => false,
                'attr' => ['class' => 'tinymce',],
                'help' => 'Renseignez votre lien portfolio',
                'help_attr' => ['class' => 'text-dark ',],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
