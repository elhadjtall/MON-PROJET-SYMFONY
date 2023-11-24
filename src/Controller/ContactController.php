<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    // On ajoute ici la variable request 
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        // ON ajoute la fonction form qui ma ramener une erreur dans le navigateur
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        // On va traiter le formulaire
        $form->handleRequest($request);
        // On creer une condition pour le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // On va faire un dump pour afficher les informations
            $contact = $form->getData();

            // On va inserer les données dans la base de donnée
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success', 'Votre demande à été envoyer avec succès §'
            );
            // La rédirection du message
            return $this->redirectToRoute('app_contact');

            //  dd($form->getData());
        }


        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(), // Creer un view sur page html
        ]);
    }
}
