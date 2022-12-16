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
                'help' => 'Renseignez votre nationalité dans la liste',
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
                'help' => 'Renseignez votre adresse',
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal',
                'required' => true,
                'help' => 'Renseignez votre code postal',
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => true,
                'help' => 'Renseignez votre ville',
            ])
            ->add('hobby', TextType::class, [
                'label' => 'Centre d\'intérêts',
                'required' => true,
                'help' => 'Renseignez vos centres d\'intérêts',
            ])
            ->add('about_me', TextareaType::class, [
                'label' => 'À propose de moi',
                'required' => true,
                'attr' => ['class' => 'tinymce', "rows" => "3"]
            ])
            ->add('github', UrlType::class, [
                'label' => 'Github',
                'required' => false,
                'help' => 'Renseignez votre lien github',
            ])
            ->add('linkedin', UrlType::class, [
                'label' => 'LinkedIn',
                'required' => false,
                'help' => 'Renseignez votre lien linkedIn',
            ])
            ->add('portfolio', UrlType::class, [
                'label' => 'Portfolio',
                'required' => false,
                'help' => 'Renseignez votre lien portfolio',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
