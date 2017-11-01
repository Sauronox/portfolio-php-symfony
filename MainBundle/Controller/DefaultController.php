<?php

namespace MainBundle\Controller;

// https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Method({"GET"})
     * @Route("/",name="acceuil")
     * @Template
     */
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository(\MainBundle\Entity\Projet::class);
        $portfolios = $repository->findAll();

        return array("portfolios" => $portfolios);
    }

}
