<?php

namespace App\Controller;
use App\Form\DemandeFormType;
use App\Entity\DemandeAide;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DemandeAideController extends AbstractController
{
    /**
     * @Route("/demande", name="demande")
     */
    public function index(): Response
    {
        $demande= $this->getDoctrine()->getManager()->getRepository(DemandeAide::class)->findAll();
        return $this->render('demande/index.html.twig', ['d'=>$demande
        ]);
    }

   /**
     * @Route("/demande/ajouter", name="ajouter_demande")
     */
    public function ajouter(Request $request): Response
    {
        $demande= new DemandeAide();
        $form=$this->createForm(DemandeFormType::class,$demande);
        $form-> handleRequest($request);
 
        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute('demande');
 
        }
        return $this->render('demande/creation.html.twig', [
            'demande'=>$demande,
         'f' => $form->createView() ]);
    }

    

    /**
     * @Route("/demande/afficher",name="afficher_demande",methods={"GET"})
     */
    public function afficher(): Response
    {$demande= $this->getDoctrine()->getManager()->getRepository(DemandeAide::class)->findAll();
        return $this->render('demande/afficher.html.twig', [
            'd'=>$demande
        ]);
    }
    /**
     * @Route("/demande/afficher_user",name="afficher_demande_user",methods={"GET"})
     */
    public function afficher_user(): Response
    {$demande= $this->getDoctrine()->getManager()->getRepository(DemandeAide::class)->findAll();
        return $this->render('demande/afficher_user.html.twig', [
            'd'=>$demande
        ]);
    }

    /**
     * @Route("/demande/modifier/{id}", name="modifier_demande")
     */
    public function update(Request $request,$id): Response
    {
        $demande = $this->getDoctrine()->getManager()->getRepository(DemandeAide::class)->find($id);

        $form = $this->createForm(DemandeFormType::class,$demande);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('demande');
        }
        return $this->render('demande/modifier.html.twig',['f'=>$form->createView()]);


    }
/**
     * @Route("/demande/supprimer/{id}", name="supprimer_demande")
     */
    public function delete(DemandeAide $demande): Response
    {
        $em= $this->getDoctrine()->getManager();
        $em->remove($demande);
        $em->flush();
        return $this->redirectToRoute('demande');
    }
}
