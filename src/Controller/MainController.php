<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function accueil(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/aboutus', name: 'aboutus')]
    public function aboutus(): Response
    {
        $fichier = '../Data/team.json';
        $fichierdecode = file_get_contents($fichier);
        $fichierFondateurs = json_decode($fichierdecode);
        return $this->render('main/aboutus.html.twig', [
            'controller_name' => 'MainController',
            'fichierFondateurs' => $fichierFondateurs
        ]);
    }

}
