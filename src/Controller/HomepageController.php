<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'homepage.index')]
    public function index(): Response
    {
        /*
        Débogage :
        - dump : affiche la donnée dans la page
        - dd (dump and die) : affiche la donnée puis stoppe le script
        Propriétés de la requête :
        - request : $_POST
        - query : $_GET
        */
        
        // // Récupération d'une donnée envoyée en $_POST 
        // $post = $this->requestStack->getMainRequest()->request->get('key');
        // dd($post);
        
        // dd($this->requestStack->getMainRequest());

        // return new Response('{"key" : "value" }', Response::HTTP_CREATED, [
        //     'Content-Type' => 'application/json'
        // ]);

        // render : appel la view 
        //La clé du tableau associatif devient une variable dans le twig
        return $this->render('homepage/index.html.twig', [
            'my_array' => ['value0', 'value1', 'value2'],
            'assoc_array' => [
                'key0' => 'value0',
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            // Ici qu'on dois toujours appeler le fichier qu'on veut créer
            // Pour appeler la date en php on utilise la fonction now
            'now' => new \DateTime(),
        ]); //appeler le fichier qui se trouve dans le dossier templates et ensuite homepage 
        
        
    }
    #[Route('/hello/{name}', name:'homepage.hello')]
    public function hello(string $name): Response {
        return $this->render('homepage/hello.html.twig', [ 'name' => $name, ]);
    }
}
