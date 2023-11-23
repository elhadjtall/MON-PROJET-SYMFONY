<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Nom requis'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le nom du produit est trop court',
                        'maxMessage' => 'Le nom du produit est trop long',
                    ]),
                ],
            ])
            ->add('price', MoneyType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le prix est requis'
                    ]),
                    new Positive([
                        'message' => 'Le montant doit être positif'
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description est requise'
                    ]),
                ],
                'invalid_message' => 'Le prix doit toujours être en chiffre'
            ])
            ->add('quantity', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La quantité est requise'
                    ]),
                ],
            ])
            ->add('image', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Télécharger une image est requis'
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
