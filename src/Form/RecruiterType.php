<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecruiterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatarFile', VichFileType::class, [
                'label' => 'Photo de Profil',
                'label_attr' => ['class' => 'font-subtitle mt-2 text-decoration-none'],
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Cochez pour supprimer',
                'download_uri' => false,
            ])
            ->add('firstname', TextType::class, [
                "label" => "Prénom"
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom"
            ])
            ->add('phoneNumber', TypeIntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
