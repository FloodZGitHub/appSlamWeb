<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Utilisateur;
use App\Entity\Messagechat;
use App\Form\AddMessageType;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'message')]
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    #[Route('/boiteReception', name: 'BoiteReception')]
    public function boiteReception(): Response
    {
        $em = $this->getDoctrine();
        $repoMessage = $em->getRepository(Messagechat::class);
        $messages = $this->getUser()->getUtilisateur()->getMessagerecu();
        return $this->render('message/boiteReception.html.twig', [
            'messages'=>$messages
        ]);


    }

    
    #[Route('/boiteEnvoi', name: 'BoiteEnvoi')]
    public function boiteEnvoi(Request $request): Response
    {
        $em = $this->getDoctrine();
        $repoMessage = $em->getRepository(Messagechat::class);
        $messages = $this->getUser()->getUtilisateur()->getMessageenvoi();

        if ($request->get('supp')!=null){
            $message = $repoMessage->find($request->get('supp'));
            if($message!=null){
                $em->getManager()->remove($message);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('BoiteEnvoi');
            }


        return $this->render('message/boiteEnvoi.html.twig', [
            'messages'=>$messages
        ]);
    }

    #[Route('/user-AjouterMessage', name: 'AjouterMessage')]
    public function ajouterMessage(Request $request): Response
    {
        $message = new Messagechat();
        $utilisateur = $this->getUser()->getUtilisateur();
        $form = $this->createForm(AddMessageType::class, $message);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $message->setDateenvoi(new \DateTime());
                $message->setUserenvoi($utilisateur);
                $user = $form->get('userrecoi')->getData();
                $t = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user);
                $message->setUserrecoi($t);
                $em->persist($message);
                $em->flush();
                $this->addFlash('notice', 'Message envoyé');
                return $this->redirectToRoute('BoiteEnvoi');

                }
        }
        return $this->render('message/ajouterMessage.html.twig', [
        'form' => $form->createView()
        ]);
    }
}
