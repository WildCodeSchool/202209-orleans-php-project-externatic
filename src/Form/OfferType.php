<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\Skill;
use App\Entity\Recruiter;
use App\Repository\SkillRepository;
use App\Repository\RecruiterRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

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
                'years' => range(date('Y') - 50, date('Y')),
                'widget' => 'single_text',
                'help' => 'Jour/Mois/Année'
            ])
            ->add('description', CKEditorType::class)
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (SkillRepository $skillRepository) {
                    return $skillRepository->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
            ])

            ->add('annualWage', MoneyType::class, [
                'label' => 'Salaire',
            ])
            ->add('recruiter', EntityType::class, [
                'class' => Recruiter::class,
                'choice_label' => 'user.lastname',
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (RecruiterRepository $recruiterRepository) {
                    return $recruiterRepository->createQueryBuilder('recruiter')
                    ->join('recruiter.user', 'user')
                    ->orderBy('user.lastname', 'DESC');
                },
            ])
            ->add('isImportant', CheckboxType::class, [
                'label' => 'Important',
                'label_attr' => ['class' => 'font-subtitle fs-5'],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
