<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use http\Env\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{

    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, ProduitRepository $repoProduit): Response
    {
        $tItemPanier = array();
        $tItemPrixAchat = array();
        $tCountItem = array();
        $iSum = 0;
        $sPanier = $session->get('s_panier');
        foreach($sPanier as $iKey => $iValue){
            //echo $iKey ." ". $iValue;
            $item = $repoProduit->find($iKey);
            $tItemPanier[] = $item;
            $tItemPrixAchat[] = $item->getPrix() * $iValue;
            $tCountItem[] = $iValue;
            $iSum = $iSum + ($item->getPrix() * $iValue);
        }
        //dump($tItemPanier);
        //dump($tCountPanier);

        //dump($sPanier); die;
        return $this->render('panier/index.html.twig', [
            'titemPanier' => $tItemPanier,
            'tnbItem' => $tCountItem,
            'tiPrixAchat' => $tItemPrixAchat ,
            'iSum' => $iSum
        ]);
    }

    #[Route('/add/{id}', name: 'app_add_panier', methods: ['GET'])]
    public function show(Produit $produit, SessionInterface $session): Response
    {

        $iProduitId = $produit->getId();

        $sPanier = $session->get('s_panier',[]);
        if(!empty($sPanier[$iProduitId])){
            $sPanier[$iProduitId] ++;
        }else{
            $sPanier[$iProduitId] = 1;
        }

        $session->set('s_panier', $sPanier);


      //dump($session->get('s_panier')); //die;
       return $this->redirectToRoute("app_liste_produit");
    }
}
