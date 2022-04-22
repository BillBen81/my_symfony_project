<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(Request $request, UserRepository $repoUser, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $plainPwd = $form->getData()->getPassword();
            $password = $userPasswordHasher->hashPassword($user, $plainPwd);
            //dump($password); die;
            $user->setPassword($password);
            $em = $repoUser->add($user);
            return $this->redirectToRoute('app_panier');
        }
        return $this->render('user/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
