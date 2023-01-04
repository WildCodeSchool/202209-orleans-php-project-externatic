<?php

namespace App\Form;

use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OfferType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'offre',
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('postalCode', IntegerType::class, [
                'label' => 'Code Postal',
            ])
            ->add('targetDate', DateType::class, [
                'label' => 'Pour le',
                'label_attr' => ['class' => 'font-subtitle'],
                'format' => 'dd-MM-yyyy',
                'help' => 'Jour/Mois/Année'
                ])
            ->add('description', TextareaType::class, [
                'attr' => ["rows" => "10"]
            ])
            ->add('annualWage', MoneyType::class, [
                'label' => 'Salaire',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
