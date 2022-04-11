<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\InformationType;
use App\Form\InscriptionType;
use App\Entity\Utilisateur;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{

    #[Route('/inscrire', name: 'inscrire')]
    public function ajoutUser(Request $request, UserPasswordHasherInterface $passwordHasher):Response{

        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setRoles(array('ROLE_USER'));
                $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('notice', 'Inscription réussie');
                return $this->redirectToRoute('app_login');
            }
        }
        return $this->render('utilisateur/inscrire.html.twig', [
        'form' => $form->createView()
        ]);
        }


    #[Route('/utilisateur', name: 'utilisateur')]
    public function index(Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $user = $this->getUser();
        $form = $this->createForm(InformationType::class, $utilisateur);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $utilisateur->setDateInscription(new \DateTime());
                $utilisateur->setUser($user);
                $em->persist($utilisateur);
                $em->flush();
                $this->addFlash('notice','Information envoyé !');
            }
        return $this->redirectToRoute('accueil');
        }
        return $this->render('utilisateur/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}