<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
// Ici on ajoute la propriété dynamique avec AllowDynamicProperties qui fait disparaisse le warning (c'est à dire le tiret rouge)
#[AllowDynamicProperties]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $quantity = null;

    #[ORM\Column(length: 255)]
    // On modifie ce code pour permettre à l'affichage de l'image
    // Pour la clé privée
    private UploadedFile|null|string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
    //Modifier ce code et l'adapter en fonction du code en bas 
    public function getImage():UploadedFile|null|string
    {
        return $this->image;
    }
    // On modifier le code pour permettre à l'affichage de l'image donc on ajoute les fonctions suivants 
    // null et UploadedFile
    // Une fois le code est modifier il faut aller dans le fichier ProduitController.php du dossier admin
    public function setImage(null|string|UploadedFile $image): static
    {
        $this->image = $image;

        return $this;
    }
}
