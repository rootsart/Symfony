<?php
	namespace GG\UserBundle\Controller;
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
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

	class CommandeController extends Controller{

		public function creerCommandeAction(Request $request){
			$panier = $this->get('session')->get('panier');
			if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $panier->getNb_articles() !=0) {
				$client = $this->getUser();
				$commande = new \GG\UserBundle\Entity\Commande($client, $panier);
				$this->get('session')->set('commande', $commande);
				$payer = $this->redirectToRoute('gg_paiement_payer');
				
			return $this->redirectToRoute('gg_paiement_payer');	
			}else{
				return $this->redirectToRoute('gg_boutique_panier');	
			}

				
		}

		

	}