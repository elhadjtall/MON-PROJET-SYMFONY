<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture
{
    // On crée une constante privée
    private const NB_PRODUITS = 30;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::NB_PRODUITS; $i++) {
            $entity = new Produit();
            $entity
                ->setName("Produit $i")
                ->setPrice(mt_rand(1, 999))
                ->setDescription("Description produit $i")
                ->setQuantity(mt_rand(0, 10))
                ->setImage('image.jpeg')
            ;
            $manager->persist($entity); // persist 
        }

        $manager->flush(); // flush permet d'exécuter tous les éléments en attente.
    }
}
