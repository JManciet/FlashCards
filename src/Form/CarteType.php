<?php

namespace App\Form;

use App\Entity\Carte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CarteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('reponse', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('image_question', FileType::class, [
                'attr' => ['class' => 'image-input custom-file',
                            'onchange' => 'previewImage(this)'],
                'label' => 'Brochure (PDF file)',
                'data_class' => null,
                // unmapped signifie que ce champ n'est associé à aucune propriété de l'entité
                'mapped' => false,

                // le rendre optionnel afin de ne pas avoir à recharger le fichier PDF
                // à chaque fois que vous modifiez les détails du produit
                'required' => false,

                // contraintes pour le chargement des images
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier image valide',
                    ])
                ],
            ])
            ->add('image_reponse', FileType::class, [
                'attr' => ['class' => 'image-input custom-file',
                            'onchange' => 'previewImage(this)'],
                'label' => 'Brochure (PDF file)',
                'data_class' => null,
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier image valide',
                    ])
                ],
            ])
            ->add('image_question_delete', HiddenType::class, [
                'attr' => ['class' => 'hidden-delete'],
                'required'   => false,
                'mapped' => false
            ])
            ->add('image_reponse_delete', HiddenType::class, [
                'attr' => ['class' => 'hidden-delete'],
                'required'   => false,
                'mapped' => false
            ])
            // ->add('deck', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Carte::class,
        ]);
    }
}
