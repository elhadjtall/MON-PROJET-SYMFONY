<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // dd($options);
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
                'invalid_message' => 'Le prix doit toujours être en chiffre' // Ceci est un contrainte de message
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description est requise'
                    ]),
                ],
            ])
            ->add('quantity', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La quantité est requise'
                    ]),
                    new PositiveOrZero([ // Cette fonction sert à dire que la quantity doit être positive
                        'message' => 'La quantité doivent pas être positive '
                    ]),
                ],
            ])
            // Ceci est le code de la gestion des images dans le formulaire
            ->add('image', FileType::class, [
                'data_class' => null,
                //Si le produit est ajouté, ojout de contraintes sur le champ de sélection de fichier // si le produit est modifier, pas de contraintes
                'constraints' => $options['data']->getId() ? [] : [
                    new NotBlank([
                        'message' => 'Télécharger une image est requis'
                    ]),
                    // Contraintes pour les images de precisions
                    new Image([
                        // Ceci defini le type de message generer 
                        'mimeTypesMessage' => " Le format de l'image n'est pas autorité",
                        'mimeTypes' => [ 'image/jpeg', 'image/gif', 'image/png' ]
                        // Lorsqu'on teste dans le navigateur, il nous envoie un message d'erreurs pour installer un composer voir la note de symfony
                        // La commande à executer : composer req mime
                        // Lorsqu'on telecherge l'image dans la liste des tableaux, on ne voit pas l'image afficher 
                        // Cela est dû à une modification dans le dossier src/ Entity = fichier php : Produit.php dans le code image (string voir le code)
                    ])
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
