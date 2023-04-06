<?php

namespace App\Form;

use App\Entity\Deck;
use App\Entity\Carte;
use App\Form\CarteType;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DeckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('visibilite', CheckboxType::class, [
                'attr' => ['class' => 'form-control'],
                'required'   => false,
                'label' => 'Privé'
            ])
            ->add('titre', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'required'   => false,
            ])
            ->add('categorie', EntityType::class, [
                'attr' => ['class' => 'form-control'],
                'class' => Categorie::class
                ])
            ->add('cartes', CollectionType::class, [
                'label' => false,
                'entry_type' => CarteType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success'],
                'label' => 'Créer le deck'
                ])
            ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Deck::class,
        ]);
    }
}
