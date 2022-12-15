<?php

namespace App\Form;

use DateTime;
use App\Entity\Offer;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('postalCode', TextType::class)
            ->add('city', TextType::class)
            ->add('created_at', DateTime::class)
            ->add('targetDate', DateTime::class)
            ->add('annualWage', IntegerType::class)
            ->add('isImportant', ChoiceType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
