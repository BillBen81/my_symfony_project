<?php

namespace App\Controller;

use App\Entity\Entreprises;
use App\Form\EntreprisesType;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/entreprises')]
class EntreprisesController extends AbstractController
{
    #[Route('/', name: 'app_entreprises_index', methods: ['GET'])]
    #[Route('/search', name: 'app_search_list', methods: ['POST'])]
    public function index(EntrepriseRepository $entrepriseRepository, Request $request): Response
    {
        if($request->isMethod('GET')){
            $listEntreprise = $entrepriseRepository->findAll();
        }else{
            $nom = $request->request->get('nom');
            $email = $request->request->get('email');
            //dump($request->get('email')); die;
            $listEntreprise = $entrepriseRepository->search($nom, $email);
        }
        return $this->render('entreprises/index.html.twig', [
            'entreprises' => $listEntreprise,
        ]);
    }

    #[Route('/new', name: 'app_entreprises_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntrepriseRepository $entrepriseRepository): Response
    {
        $entreprise = new Entreprises();
        $form = $this->createForm(EntreprisesType::class, $entreprise);
        $form->handleRequest($request);
        //dump($entreprise); die;

        if ($form->isSubmitted() && $form->isValid()) {
            //$entreprise->setCreateAt(new \DateTimeImmutable());
            //$entreprise->setUpdateAt(new \DateTimeImmutable());
            //dump($entreprise); die;
            $entrepriseRepository->add($entreprise);
            return $this->redirectToRoute('app_entreprises_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entreprises/new.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entreprises_show', methods: ['GET'])]
    public function show(Entreprises $entreprise): Response
    {
        return $this->render('entreprises/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entreprises_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entreprises $entreprise, EntrepriseRepository $entrepriseRepository): Response
    {
        $form = $this->createForm(EntreprisesType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrepriseRepository->add($entreprise);
            return $this->redirectToRoute('app_entreprises_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entreprises/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entreprises_delete', methods: ['POST'])]
    public function delete(Request $request, Entreprises $entreprise, EntrepriseRepository $entrepriseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entreprise->getId(), $request->request->get('_token'))) {
            $entrepriseRepository->remove($entreprise);
        }

        return $this->redirectToRoute('app_entreprises_index', [], Response::HTTP_SEE_OTHER);
    }
}
