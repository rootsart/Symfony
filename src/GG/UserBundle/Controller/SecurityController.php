<?php

namespace GG\UserBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GG\UserBundle\Form\Identifiants_UType;
use GG\UserBundle\Entity\Identifiants_U;
use GG\UserBundle\Entity\Usager;
use GG\UserBundle\Form\UsagerType;
use GG\BoutiqueBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Forms;


class SecurityController extends Controller{
  
  public function loginAction(Request $request){

      // Si le visiteur est déjà identifié, on le redirige vers l'accueil
      if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

        return $this->redirectToRoute('homepage');
      } 
      $panier = new \GG\BoutiqueBundle\Entity\Panier;
      $this->get('session')->set('panier', $panier);
      $identifiants = new Identifiants_U(); 
      $formConn = $this->createForm(Identifiants_UType::class, $identifiants);
      $formConn = $formConn->createView();

      // Le service authentication_utils permet de récupérer le nom d'utilisateur
      // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide, (mauvais mot de passe par exemple)
      $authenticationUtils = $this->get('security.authentication_utils');

      $resp = $this->render('GGUserBundle:Security:connect.html.twig', array(
        'last_username' => $authenticationUtils->getLastUsername(),
        'error'         => $authenticationUtils->getLastAuthenticationError(),
        'formConn'      =>$formConn,
        ));
    
      $dert= new Response($resp->getContent());
      return($dert);
      
      
  }

  public function changePwd_EmailAction(){
      $content = $this->get('templating')->render('GGUserBundle:Resetting:request.html.twig', array("message" => $message));
        return new Response($content);
  }

  

}

