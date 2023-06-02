<?php

namespace App\Controller;

use App\Entity\Formulaire;
use App\Entity\Images;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\FormulaireType;

class FormulaireController extends AbstractController
{
   /**
     * @Route("/formulaire", name="formulaire")
     */
    public function index(): Response
    {
        $formulaire= $this->getDoctrine()->getManager()->getRepository(Formulaire::class)->findAll();
        return $this->render('formulaire/index.html.twig', ['f'=>$formulaire
        ]);
    }

   /**
     * @Route("/formulaire/ajouter", name="ajouter_formulaire" ,methods={"GET","POST"})
     */
    public function ajouter(Request $request): Response
    {
        $formulaire= new Formulaire();
        $form=$this->createForm(FormulaireType::class,$formulaire);
        $form-> handleRequest($request);
 
        if($form->isSubmitted() && $form->isValid()){
            //On récupére les images transmises
            $images=$form->get('images')->getData();
            
            //On boucle sur les images
            foreach($images as $image){
             //on génere un nouveau nom de fichier
             $fichier=md5(uniqid()). '.' .$image->guessExtension();
 
             //On copie le fichier dans le dossier uploads
            $image->move(
             $this->getParameter('images_directory'),
             $fichier
            );
 
            //on stocke l'image dans la base de données (son nom)
            $img=new Images();
            $img->setName($fichier);
            $formulaire->addImage($img);


        }
            $em= $this->getDoctrine()->getManager();
            $em->persist($formulaire);
            $em->flush();
            return $this->redirectToRoute('formulaire');
 
        }
        return $this->render('formulaire/creation.html.twig', [
            'formulaire'=>$formulaire,
         'f' => $form->createView() ]);
    }

    

    /**
     * @Route("/formulaire/afficher",name="afficher_formulaire",methods={"GET"})
     */
    public function afficher(): Response
    {$formulaire= $this->getDoctrine()->getManager()->getRepository(Formulaire::class)->findAll();
        return $this->render('formulaire/afficher.html.twig', [
            'f'=>$formulaire
        ]);
    }

    /**
     * @Route("/formulaire/modifier/{id}", name="modifier_formulaire",methods={"GET","POST"})
     */
    public function modifier(Request $request,Formulaire $formulaire): Response
    {
        

        $form = $this->createForm(FormulaireType::class,$formulaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            //On récupére les images transmises
            $images=$form->get('images')->getData();
            
            //On boucle sur les images
            foreach($images as $image){
             //on génere un nouveau nom de fichier
             $fichier=md5(uniqid()). '.' .$image->guessExtension();
 
             //On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
             $fichier
            );
 
            //on stocke l'image dans la base de données (son nom)
            $img=new Images();
            $img->setName($fichier);
            $formulaire->addImage($img);


        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($formulaire);
        $entityManager->flush();

            return $this->redirectToRoute('formulaire');
        }
        return $this->render('formulaire/modifier.html.twig',[
            'formulaire'=>$formulaire,
            'f'=>$form->createView()]);


    }
/**
     * @Route("/formulaire/supprimer/{id}", name="supprimer_formulaire")
     */
    public function supprimer(Formulaire $formulaire): Response
    {
        $em= $this->getDoctrine()->getManager();
        $em->remove($formulaire);
        $em->flush();
        return $this->redirectToRoute('formulaire');
    }

    //supprimer une image
    /**
     * @Route("/image/supprimer/{id}", name="supprimer_image",methods={"DELETE"})
     */
    public function supprimerImage(Images $image,Request $request){
        $data=json_decode($request->getContent(),true);
        //on verifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            $nom=$image->getName();
            unlink($this->getParameter('image_directory').'/'.$nom);
            // on supprime l'entrée de la base
            $em =$this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
            //On répond en json
            return new JsonResponse(['succes'=> 1]);
        }else{
            return new JsonResponse(['error'=>'Token Invalide'],400);
        }
        } 


    }

