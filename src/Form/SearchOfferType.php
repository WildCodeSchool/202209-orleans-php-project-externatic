<?php

namespace App\Form;

use App\Entity\SearchOfferModule;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchOfferType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', TextType::class, [
                'label' => 'Recherche',
                "required" => false,
            ])
            ->add('location', TextType::class, [
                "label" => "Ville",
                "required" => false,
            ])
            ->add('range', RangeType::class, [
                "label" => "Rayon",
                "required" => true,
                "attr" => [
                    "min" => 10,
                    "max" => 100,
                    "step" => 10,
                ],
                "label_attr" => [
                    "class" => "m-0"
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => SearchOfferModule::class
        ]);
    }
}
