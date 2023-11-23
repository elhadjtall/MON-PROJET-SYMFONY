<?php

namespace App\Controller\Admin;

use App\Entity\Produit; // Il faut imporeter le produit n'oublie pas toujours l'importation
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class ProduitController extends AbstractController
{
    //Ripository permet d'acceder au contenu d'une base de données
    // On injecte notre produit qui nous concerne en utilisant la fonction construct
    // Recuperer la requette HTTP en Symfony on utilise la fonction requestStack
    public function __construct(private ProduitRepository $produitRepository , private RequestStack $requestStack, private EntityManagerInterface $entityManager,)
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
    #[Route('/produit/update/{id}', name: 'admin.produit.update')]
    // La route creer par l'identifiant id sera mis dans les acolates de form en variable ensuite lui donnée une valeur
    // Donc on aura : public function form( int $id = null): Response
    //Si l'id à une valeur, on est entrain de modifier, si non c'est le contraire
    public function form( int $id = null): Response
    {
        // Creation d'un formulaire
        // Pour cela on creer les entity
        //Ici qu'on verifie si l'id à une valeur
        $entity = $id ? $this->produitRepository->find($id) : new Produit();
        $type = ProduitType::class;
        $form = $this->createForm($type, $entity);

        //Récuperer la saisie précédente dans la réquête http
        $form->handleRequest($this->requestStack->getMainRequest());

        //Si le formulaire est valide et soumis
        if($form->isSubmitted() && $form->isValid()){
            // dd($entity);
            // Inserer les données dans la base de données
            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            // Afficher un message de confirmation
            // Ici on modifie le message qu'on envoie car si l'id à une valeur on est entrain de modifier si non on est ajoute
            $message = $id ? 'Produit Modifier' : 'Produit created';
            // Message flash : message stocké en session, supprimé suite à son affichage
            $this->addFlash('notice', $message);

            // redirection vers la page d'acceuil de l'admin qui gère les produits
            return $this->redirectToRoute('admin.produit.index');
        }

        return $this->render('admin/produit/form.html.twig', [
            'form' => $form->createView(), //Ce code transforme ce code en pur html
        ]);
    }
    // On creer une nouvelle route pour le bouton de suppression
    #[Route('/produit/delete/{id}', name: 'admin.produit.delete')]
    // Creer une fonction public pour envoyer une reponse de redirection
    public function delete (int $id) :RedirectResponse 
    {
        // Selectionner l'entité à supprimer avec la fonction find
        $entity = $this->produitRepository->find($id);
        //Supprimer l'entité avec la fonction remove
        $this->entityManager->remove($entity);
        
        // Il faut ajouter la fonction flush pour pouvoir supprimer un produit
        $this->entityManager->flush();

        // Redirection de la route vers la page admin 
        return $this->redirectToRoute('admin.produit.index');
    }
}