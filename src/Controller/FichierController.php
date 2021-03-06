<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\AjoutFichierType;
use App\Entity\Fichier;

class FichierController extends AbstractController
{
    #[Route('/fichier', name: 'app_fichier')]
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(AjoutFichierType::class);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $fichier = $form->get('fichier')->getData();
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
                    }
                    catch(FileException $e){
                    $this->addFlash('notice', 'Erreur d\'envoi');
                    }
                }
                return $this->redirectToRoute('ajout-fichier');
            }
        }

        return $this->render('fichier/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
