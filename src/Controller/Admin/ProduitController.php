<?php

namespace App\Controller\Admin;

use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class ProduitController extends AbstractController
{
    //Ripository permet d'acceder au contenu d'une base de données
    // On injecte notre produit qui nous concerne en utilisant la fonction construct
    // Recuperer la requette HTTP en Symfony on utilise la fonction requestStack
    public function __construct(private ProduitRepository $produitRepository , private RequestStack $requestStack)
    {
        
    }
    #[Route('/produit', name: 'admin.produit.index')]
    public function index(): Response
    {
        return $this->render('admin/produit/index.html.twig', [
            'produits' => $this->produitRepository->findAll(), // Ceci permet d'envoyer la vue c'est à dire faire apparaître les produits dans une page appeler index.
        ]);
    }
    #[Route('/produit/form', name: 'admin.produit.form')]
    public function form(): Response
    {
        // Creation d'un formulaire
        // Pour cela on creer les entity
        $entity = new Produit();
        $type = ProduitType::class;
        $form = $this->createForm($type, $entity);

        //Récuperer la saisie précédente dans la réquête http
        $form->handleRequest($this->requestStack->getMainRequest());

        //Si le formulaire est valide et soumis
        if($form->isSubmitted() && $form->isValid()){
            dd($entity)
        }

        return $this->render('admin/produit/form.html.twig', [
            'form' => $form->createView(), //Ce code transforme ce code en pur html
        ]);
    }
}
