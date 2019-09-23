<?php
	namespace GG\BoutiqueBundle\Controller;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use GG\BoutiqueBundle\Form\ArticleType;
	use GG\BoutiqueBundle\Entity\Image;
	use GG\BoutiqueBundle\Entity\Article;
	use GG\BoutiqueBundle\Entity\User;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use GG\BoutiqueBundle\Form\ImageType;
	use GG\BoutiqueBundle\Form\UserType;
	use GG\BoutiqueBundle\Form\IdentifiantsType;
	use GG\BoutiqueBundle\Entity\Identifiants;
	use Symfony\Component\HttpFoundation\Session\Session;
	use GG\BoutiqueBundle\Entity\Panier;
	use GG\BoutiqueBundle\Entity\Mail;
	use GG\BoutiqueBundle\Form\MailType;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

	class BoutiqueController extends Controller{
	    
		/**
		* @Route("/", name="homepage")
		*/
		public function indexAction(){
			$content = $this->get('templating')->render('GGBoutiqueBundle::layout.html.twig');
        	return new Response($content);
		}
	    public function showAction($id){
			$repository = $this
				->getDoctrine()
				->getManager()
				->getRepository('GGBoutiqueBundle:Article');
			$liste_Articles = $repository->myFindAll();
			$this->get('session')->set('listeArticles', $liste_Articles);
			 
			//var_dump($liste_Articles);
	        $content = $this->get('templating')->render('GGBoutiqueBundle:Boutique:showArticles.html.twig', array("liste_Articles" => $liste_Articles));
			return new Response($content);
	    }

	    public function showByCategorieAction($categorie){
	    	$repository = $this
				->getDoctrine()
				->getManager()
				->getRepository('GGBoutiqueBundle:Categorie');
			$Entitecategorie = $repository->findByCategorie($categorie);


			$repository = $this
				->getDoctrine()
				->getManager()
				->getRepository('GGBoutiqueBundle:Article');
			$liste_Articles = $repository->findByCategorie($Entitecategorie);
			if(!empty($liste_Articles)){
				$this->get('session')->set('listeArticles', $liste_Articles);
	        	$content = $this->get('templating')->render('GGBoutiqueBundle:Boutique:showArticles.html.twig', array("liste_Articles" => $liste_Articles));
				return new Response($content);	
			}else{
				$message="Aucun élément dans la catégorie ". $categorie ." pour l'instant.";
				$content = $this->get('templating')->render('GGBoutiqueBundle:Boutique:showArticles.html.twig', array("message" => $message));
				return new Response($content);
			}
			
	    }

	    public function showByRubriqueAction($rubrique){
	    	$repository = $this
				->getDoctrine()
				->getManager()
				->getRepository('GGBoutiqueBundle:Rubriques');
			$Entiterubrique = $repository->findByRubrique($rubrique);

			$repository = $this
				->getDoctrine()
				->getManager()
				->getRepository('GGBoutiqueBundle:Article');
			$liste_Articles = $repository->findByRubrique($Entiterubrique);
			if(!empty($liste_Articles)){
				$this->get('session')->set('listeArticles', $liste_Articles);
				
				//var_dump($liste_Articles->rowCount());
		        $content = $this->get('templating')->render('GGBoutiqueBundle:Boutique:showArticles.html.twig', array("liste_Articles" => $liste_Articles));
				return new Response($content);
			}else{
					$message="Aucun élément dans la rubrique ". $rubrique ." pour l'instant.";
					$content = $this->get('templating')->render('GGBoutiqueBundle:Boutique:showArticles.html.twig', array("message" => $message));
				return new Response($content);
				}
	    }
	   

	    public function inscriptionAction(Request $request){
	    	if($this->get('session')->get('email')==null){
	    		$user = new User();	
	    	$form = $this->createForm(UserType::class, $user);
	    	 if ($form->handleRequest($request)->isValid()) {//Form::isSubmitted()

						$em = $this->getDoctrine()->getManager();

						$em->persist($user);
						//$em->persist($user->getAdresse());
						$em->flush();
						$session = $request->getSession();
						$session->getFlashBag()->add('info', 'Bienvenue, vous avez bien été  enregistré, merci de vous connecter pour profiter de notre boutique.');
						return $this->redirect($this->generateUrl('homepage'));
						
					}else{
						$test = 'Bin allo koi !!!';
				return $this->render('GGBoutiqueBundle:Boutique:inscription.html.twig', array(
					'form' => $form->createView()));
					}
	    	}else{
	    		 return $this->render('GGBoutiqueBundle::layout.html.twig');
	    	}
	    	
					
			
	    }

	   
	    public function deconnexionAction(Request $request){
	    	 if($this->get('session')->get('panier')){

	    	 	$panier = $this->get('session')->get('panier');
	    	 	$panier -> vider();

	    	 	$this->get('session')->set('email', null);
	    	 	$this->get('session')->set('panier', null);	

        		return $this->redirectToRoute('fos_user_security_logout');
	    	 }
	    }


	    public function contactAction(){
	    	//return $this->render('GGBoutiqueBundle:Boutique:contact.html.twig');
	    	$mail = new Mail();
	    	$formMail = $this->createForm(MailType::class, $mail);
	    	return $this->render('GGBoutiqueBundle:Boutique:contact.html.twig', array(
					'formMail' => $formMail->createView()));
	    }

	    
	    
}

