<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; // Importation de la classe Route

class ProduitController extends AbstractController
{
    // Creer la classe de constructeur
    public function __construct(private ProduitRepository $produitRepository) // Ceci est une classe de constructeur
    {
        $this->produitRepository = $produitRepository; 
    }
    #[Route('/produit', name: 'produit.index')] // Ajout de l'annotation Route avec l'importation correcte
    public function index(): Response
    {
        dump($this->produitRepository->findAll());
        return $this->render('produit/index.html.twig', [
            'produits' => $this->produitRepository->findAll()  //Pour afficher des views on dois faire un tableau en utilisans une fonction findall
        ]);
    }
}
