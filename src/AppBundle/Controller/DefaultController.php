<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GG\BoutiqueBundle\Form\IdentifiantsType;
use GG\BoutiqueBundle\Entity\Identifiants;


class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
		$identifiants = new Identifiants();	
		$formConn = $this->createForm(IdentifiantsType::class, $identifiants);
		$formConn = $formConn->createView();

		//return $this->render('GGBoutiqueBundle::layout.html.twig', array('formConn' => $formConn->createView()));
       	$content = $this->get('templating')->render('GGBoutiqueBundle::layout.html.twig', array("formConn" => $formConn));
        return new Response($content);
    }
}


//NE SERT A RIEN, A SUPPRIMER DES QUE POSSIBLE