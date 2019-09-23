<?php

namespace GG\PaiementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GGPaiementBundle:Default:index.html.twig');
    }

    public function testPaiementAction(){
    	$pluginControlller= $this->container->get('payment.plugin_controller');
    	return new RedirectResponse($this->generateUrl('gg_paiement_payer', array(
	                    'pluginControlller' => $pluginControlller,
	                )));
    }
}
