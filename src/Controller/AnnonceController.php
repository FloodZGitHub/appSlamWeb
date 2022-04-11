<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Fichier;
use App\Entity\Annonce;
use App\Entity\User;
use App\Entity\Utilisateur;
use App\Entity\Type;
use App\Form\AddAnnonceType;
use Symfony\Component\String\Slugger\SluggerInterface;

class AnnonceController extends AbstractController
{
    #[Route('/user-AjouterAnnonce', name: 'AjouterAnnonce')]
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $annonce = new Annonce();
        $utilisateur = $this->getUser()->getUtilisateur();
        $form = $this->createForm(AddAnnonceType::class, $annonce);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $annonce->setDatepost(new \DateTime());
                $annonce->setUtilisateur($utilisateur);
                $type = $form->get('type')->getData();
                $t = $this->getDoctrine()->getRepository(Type::class)->find($type);
                $annonce->addType($t);
                $fichier = $form->get('fichier')->getData();
                $fichier2 = $form->get('fichier2')->getData();
                $fichier3 = $form->get('fichier3')->getData();
                if($fichier){
                    $nomFichier = pathinfo($fichier->getClientOriginalName(),
                    PATHINFO_FILENAME);
                    $nomFichier = $slugger->slug($nomFichier);
                    $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier->guessExtension();
                    try{
                        $f = new Fichier();
                        $f->setNom($nomFichier);
                        $f->setOriginal($fichier->getClientOriginalName());
                        $f->setExtension($fichier->guessExtension());
                        $f->setTaille($fichier->getSize());
                        //$f->setAnnonce();
                        $fichier->move($this->getParameter('file_directory'), $nomFichier);
                        $this->addFlash('notice', 'Fichier envoyé');
                        $annonce->addFichier($f);
                        $em->persist($f);
                    }
                    catch(FileException $e){
                    $this->addFlash('notice', 'Erreur d\'envoi');
                    }
                $em->persist($annonce);
                $em->flush();
                $this->addFlash('notice','Information envoyé !');
                }
                if($fichier2){
                    $nomFichier = pathinfo($fichier2->getClientOriginalName(),
                    PATHINFO_FILENAME);
                    $nomFichier = $slugger->slug($nomFichier);
                    $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier2->guessExtension();
                    try{
                        $f = new Fichier();
                        $f->setNom($nomFichier);
                        $f->setOriginal($fichier2->getClientOriginalName());
                        $f->setExtension($fichier2->guessExtension());
                        $f->setTaille($fichier2->getSize());
                        //$f->setAnnonce();
                        $fichier2->move($this->getParameter('file_directory'), $nomFichier);
                        $this->addFlash('notice', 'Fichier envoyé');
                        $annonce->addFichier($f);
                        $em->persist($f);
                    }
                    catch(FileException $e){
                    $this->addFlash('notice', 'Erreur d\'envoi');
                    }
                $em->persist($annonce);
                $em->flush();
                $this->addFlash('notice','Information envoyé !');
                }
                if($fichier3){
                    $nomFichier = pathinfo($fichier3->getClientOriginalName(),
                    PATHINFO_FILENAME);
                    $nomFichier = $slugger->slug($nomFichier);
                    $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier3->guessExtension();
                    try{
                        $f = new Fichier();
                        $f->setNom($nomFichier);
                        $f->setOriginal($fichier3->getClientOriginalName());
                        $f->setExtension($fichier3->guessExtension());
                        $f->setTaille($fichier3->getSize());
                        //$f->setAnnonce();
                        $fichier3->move($this->getParameter('file_directory'), $nomFichier);
                        $this->addFlash('notice', 'Fichier envoyé');
                        $annonce->addFichier($f);
                        $em->persist($f);
                    }
                    catch(FileException $e){
                    $this->addFlash('notice', 'Erreur d\'envoi');
                    }
                $em->persist($annonce);
                $em->flush();
                $this->addFlash('notice','Information envoyé !');
                }
            }
        return $this->redirectToRoute('accueil');
        }
        return $this->render('annonce/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/annonce', name: 'annonce')]
    public function annonce(): Response
    {
        $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Annonce::class);

        $annonces = $repoTheme->findBy(array(),array('datepost'=>'ASC'));
        return $this->render('annonce/annonce.html.twig', [
            'annonces'=>$annonces
        ]);
    }

    #[Route('/affichage/{id}', name: 'affichage', requirements: ["id"=>"\d+"])]
    public function telechargement(int $id): Response
    {
        $fichier = $this->getDoctrine()->getRepository(Fichier::class)->find($id);
        if ($fichier != null){
            return $this->file($this->getParameter('file_directory').'/'.$fichier->getNom(), $fichier->getOriginal());
        }
    }
}
