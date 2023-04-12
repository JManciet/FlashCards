<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UtilisateurUpdatePseudoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pseudo', TextType::class, [
            'mapped' => false,
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '50',
            ],
            'required' => true,
            'label' => 'Nouveau pseudo',
            'label_attr' => [
                'class' => 'form-label  mt-4'
            ],
            'constraints' => [
                // new Assert\Length(['min' => 2, 'max' => 50])
            ]
        ])
        ->add('password', PasswordType::class, [
            'mapped' => false,
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Mot de passe actuel',
            'label_attr' => [
                'class' => 'form-label  mt-4'
            ]
        ])
        ->add('valider', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4'
            ]
        ])
        
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
