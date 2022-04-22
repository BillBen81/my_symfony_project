<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class ListeProduitController extends AbstractController
{
    #[Route('/liste/produit', name: 'app_liste_produit')]
    public function index(ProduitRepository $produitRepository, SessionInterface $session): Response
    {
        $listeProduits = $produitRepository->findAll();
        $session->set('s_listeProduit',$listeProduits);



        return $this->render('liste_produit/index.html.twig', [
            'listeProduits' => $listeProduits,
        ]);
    }

}
