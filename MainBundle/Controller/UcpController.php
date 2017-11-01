<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use MainBundle\Form\TechnologieType;
use MainBundle\Entity\Technologie;

use MainBundle\Form\LangageType;
use MainBundle\Entity\Langage;

use MainBundle\Form\IllustrationType;
use MainBundle\Entity\Illustration;

use MainBundle\Form\PDFType;
use MainBundle\Entity\PDF;

use MainBundle\Form\SourceType;
use MainBundle\Entity\Source;

use MainBundle\Form\ProjetType;
use MainBundle\Entity\Projet;

use MainBundle\Entity\Compte;

/**
 * @Security("has_role('ROLE_USER')")
 * @Route("/ucp", name="ucp")
 */
class UcpController extends Controller {

    /**
     * @Route("/", name="ucp")
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER')")
     * @Template
     */
    public function indexAction(Request $request) {
    // https://symfony.com/doc/current/doctrine.html

        return array();
    }

    /**
     * @Route("/technologie", name="technologie")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     * @Template
     */
    public function technologieAction(Request $request) {
        $technologie = new Technologie();
        $form = $this->createForm(TechnologieType::class, $technologie);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($technologie);
                $em->flush();

                $this->addFlash('success', "Félicitation, la technologie vient d'être enregistrée !");

                return $this->redirectToRoute('technologie');
            }
            $this->addFlash('danger', "Un problème est survenu !");
        }
        
        $repository = $this->getDoctrine()->getRepository(\MainBundle\Entity\Technologie::class);
        $technologies = $repository->findAll();
        return array('form' => $form->createView(), "technologies" => $technologies);
    }
    /**
     * @Route("/langage", name="langage")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     * @Template
     */
    public function langageAction(Request $request) {
        $langage = new Langage();
        $form = $this->createForm(LangageType::class, $langage);
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                if($langage->getTemporaryImage() != null) {
                    $image = $langage->getTemporaryImage();
                    $image_name = hash('sha256', $langage->getNom()) . '.' . $image->guessExtension();
                    if (file_exists($this->getParameter('images_directory') . $image_name)) {
                        unlink($this->getParameter('images_directory') . $image_name);
                    }
                    $image->move($this->getParameter('images_directory'), $image_name);
                    $langage->setImage("fichiers/images/" . $image_name);
                
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($langage);
                    $em->flush();

                    $this->addFlash('success', "Félicitation, le langage vient d'être enregistrée !");

                    return $this->redirectToRoute('langage');
                }
            }
            $this->addFlash('danger', "Un problème est survenu !");
        }
        $repository = $this->getDoctrine()->getRepository(\MainBundle\Entity\Langage::class);
        $langages = $repository->findAll();
        
        return array('form' => $form->createView(), "langages" => $langages);
    }
    /**
     * @Route("/projet", name="projet")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     * @Template
     */
    public function projetAction(Request $request) {
        $projet = new Projet();
        $projet->addIllustration(new Illustration());
        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                foreach ($projet->getIllustrations() as $illustration_foreach) {
                    $illustration = $illustration_foreach->getTemporaryPath();
                    $illustration_name =  hash('sha256', uniqid('illustration_', true)) . '.' . $illustration->guessExtension();
                    if (file_exists($this->getParameter('illustrations_directory') . $illustration_name)) {
                        unlink($this->getParameter('illustrations_directory') . $illustration_name);
                    }
                    $illustration->move($this->getParameter('illustrations_directory'), $illustration_name);
                    $illustration_foreach->setPath("fichiers/illustrations/" . $illustration_name);
                    
                    $illustration_foreach->setProjet($projet);
                }
                
                $PDF = $projet->getPdf()->getTemporaryPath();
                $PDF_name =  hash('sha256', uniqid('pdf_', true))  . '.' . $PDF->guessExtension();
                if (file_exists($this->getParameter('PDFs_directory') . $PDF_name)) {
                    unlink($this->getParameter('PDFs_directory') . $PDF_name);
                }
                $PDF->move($this->getParameter('PDFs_directory'), $PDF_name);
                $projet->getPdf()->setPath("fichiers/PDFs/" . $PDF_name);
                $projet->getPdf()->setProjet($projet);

                $source = $projet->getSource()->getTemporaryPath();
                $source_name = hash('sha256', uniqid('source_', true)) . '.' . $source->guessExtension();
                if (file_exists($this->getParameter('sources_directory') . $source_name)) {
                    unlink($this->getParameter('sources_directory') . $source_name);
                }
                $source->move($this->getParameter('sources_directory'), $source_name);
                $projet->getSource()->setPath("fichiers/sources/" . $source_name);
                $projet->getSource()->setProjet($projet);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($projet);
                $em->flush();

                $this->addFlash('success', "Félicitation, le projet vient d'être enregistrée !");

                return $this->redirectToRoute('projet');
            }
            $this->addFlash('danger', "Un problème est survenu !");
        }

        return array('form' => $form->createView());
    }
    /**
     * @Route("/portfolio", name="portfolio")
     * @Method({"GET"})
     * @Template
     */
    public function portfolioAction(Request $request) {
    // https://symfony.com/doc/current/doctrine.html
        $repository = $this->getDoctrine()->getRepository(\MainBundle\Entity\Projet::class);
        $portfolios = $repository->findAll();
        return array("portfolios" => $portfolios);
    }

}
