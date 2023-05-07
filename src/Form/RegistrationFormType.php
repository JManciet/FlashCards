<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('pseudo', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'attr' => ['class' => 'checkbox-inline'],
                'label' => 'Accepter les conditions',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [

                'constraints' => [
                    new Regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
                    "Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole.")
                ],

                // instead of being set onto the object directly,
                // this is read and encoded in the controller
    

                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe',
                'attr' => [
                    'class' => 'form-control',
                    // 'placeholder' => 'Password'
                ]],
                'second_options' => ['label' => 'Répéter le mot de passe',
                'attr' => [
                    'class' => 'form-control',
                    // 'placeholder' => 'Password'
                ]],




                // 'mapped' => false,
                // 'attr' => ['autocomplete' => 'new-password'],
                // 'constraints' => [
                //     new NotBlank([
                //         'message' => 'Please enter a password',
                //     ]),
                //     new Length([
                //         'min' => 6,
                //         'minMessage' => 'Your password should be at least {{ limit }} characters',
                //         // max length allowed by Symfony for security reasons
                //         'max' => 4096,
                //     ]),
                // ],



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
