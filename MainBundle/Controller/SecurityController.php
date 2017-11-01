<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use MainBundle\Entity\Compte;
use MainBundle\Form\EnregistrementCompte;

class SecurityController extends Controller {

    /**
     * @Method({"GET", "POST"})
     * @Route("/connexion", name="connexion")
     * @Cache(expires="+3 days")
     * @Template
     */
    public function connexionAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return array('last_username' => $lastUsername, 'error' => $error);
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/enregistrement", name="enregistrement")
     * @Cache(expires="+3 days")
     * @Template
     */
    public function enregistrementAction(Request $request) {
        $compte = new Compte();
        $form = $this->createForm(EnregistrementCompte::class, $compte);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($compte, $compte->getPlainPassword());
            $compte->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($compte);
            $em->flush();

            return $this->redirectToRoute('acceuil');
        }

        return array('form' => $form->createView());
    }

}
