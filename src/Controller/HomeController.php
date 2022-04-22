<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'nom' => 'Christian',
        ]);
    }

    #[Route('/home/{nom}', name: 'app_getName')]
    public function getName(Request $request): Response
    {
        $nom = $request->get('nom');
        $adresse = $request->query->get('adresse');
        return $this->render('home/index.html.twig', [
            'nom' => $nom,
            'adresse' => $adresse
        ]);
    }
}
