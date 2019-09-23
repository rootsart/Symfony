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
	use Symfony\Component\HttpFoundation\JsonResponse;
	use JMS\DiExtraBundle\Annotation as DI;
	//use Symfony\Component\Process\Process;

	class PanierController extends Controller{
		/** @DI\Inject("doctrine.orm.entity_manager") */
		private $em;


		public function showPanierAction(Request $request){
			
				
			$content = 
			$this->get('templating')->render('GGBoutiqueBundle:Panier:showPanier.html.twig');
			return new Response($content);
		}

		public function ajoutPanierAction(Request $request){
			if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
				if($request->isXmlHttpRequest()){
					$idarticle ='';
					$idarticle = $request->get('id');
					$panier = $this->get('session')->get('panier');
					$article = $this->em->getRepository('GGBoutiqueBundle:Article')->find($idarticle);


					//----------------- Test disponibilités article------------------------------------
					$dispo = $article->getDispo();
					$disponibilite = $this->em->getRepository('GGBoutiqueBundle:Disponibilites')->find($dispo);
					if(!$disponibilite->getReserved() && $disponibilite->getValide()){
						$panier->addArticle($article);

						//--------Mise à jour de la disponibilité pour article stock 1-------
						if($article->getStock() == 1){
							$disponibiliteReserved = $this->em->getRepository('GGBoutiqueBundle:Disponibilites')->findReserved();
							$article->setDispo($disponibiliteReserved[0]);
							$this->em->persist($article);
							$this->em->flush($article);
						}
						//--------------------------------------------STOCK TEMPORAIRE--------------------------------------------------------------------
						$stocktemporaire = $article->getStocktemp();//---Récupération de l'id de l'entité StockTemp lié à l'article 
						$stockTempObject = $this->em->getRepository('GGBoutiqueBundle:StockTemp')->find($stocktemporaire);//---Récupération de l'entité StockTemp de l'article en BDD
						$valuestockTObject = $stockTempObject->getStocktemp();//--Récupération de sa valeur
						$newvalueStockTemp = $valuestockTObject - 1;//---Modification de la valeur du stocktemp de l'article
						$stockTempObject->setStocktemp($newvalueStockTemp);//--Attribution de la nouvelle valeur
						$this->em->persist($stockTempObject);
						$this->em->flush($stockTempObject);
						//-------------------------------------------------------------
					}
					


					$articlepanier = $panier->getArticles();
					return new JsonResponse(array('success' => true, 'nombreArticle'=>$panier->getNb_articles()));
				}
			}else{
				return new JsonResponse(array('success' => false, 'message'=>'Afin de profiter de votre boutique pleinement, merci de vous connecter.'));
			}

		}

		public function supPanierAction(Request $request){
			if($request->isXmlHttpRequest()){
				$panier = $this->get('session')->get('panier');
				$id = $request->get('id');
				$article = $this->em->getRepository('GGBoutiqueBundle:Article')->find($id);
				$panier->removeArticle($article);
				$montantPanier = $panier->getMontant();
				$montantTTC = $panier->getMontantTTC();
				$nombreArticle = $panier->getNb_articles();


				//---------- On remet le article Reserved à 0 -----------------------
				$dispoArticle = $article->getDispo();
				$disponibiliteDeBase = $this->em->getRepository('GGBoutiqueBundle:Disponibilites')->findBase();
				$disponibilite = $this->em->getRepository('GGBoutiqueBundle:Disponibilites')->find($dispoArticle);
				if($disponibilite->getReserved() == 1){
					$article->setDispo($disponibiliteDeBase[0]);
					$this->em->persist($article);
					$this->em->flush();	
				}
				//---------------------------------------------------------------------
				
				//--------------------------------------------STOCK TEMPORAIRE--------------------------------------------------------------------
				$stocktemporaire = $article->getStocktemp();//---Récupération de l'id de l'entité StockTemp lié à l'article 
				$stockTempObject = $this->em->getRepository('GGBoutiqueBundle:StockTemp')->find($stocktemporaire);//---Récupération de l'entité StockTemp de l'article en BDD
				$valuestockTObject = $stockTempObject->getStocktemp();//--Récupération de sa valeur
				$newvalueStockTemp = $valuestockTObject + 1;//---Modification de la valeur du stocktemp de l'article
				$stockTempObject->setStocktemp($newvalueStockTemp);//--Attribution de la nouvelle valeur
				$this->em->persist($stockTempObject);
				$this->em->flush($stockTempObject);
				//-------------------------------------------------------------


				$response = new JsonResponse(array('montantHT' => $montantPanier, 'montantTTC'=>$montantTTC, 'nombreArticle'=>$nombreArticle));
				return $response;
			}
		}

		public function viderPanierAction(Request $request){
			$panier = $this->get('session')->get('panier');

			//---------- On remet le article Reserved à 0 -----------------------
			$listarticle = $panier->getArticles();
			foreach ($listarticle as $key => $OBJ_article) {
				$article = $this->em->getRepository('GGBoutiqueBundle:Article')->find($OBJ_article->getId());
				$dispoArticle = $article->getDispo();
				$disponibiliteDeBase = $this->em->getRepository('GGBoutiqueBundle:Disponibilites')->findBase();
				$disponibilite = $this->em->getRepository('GGBoutiqueBundle:Disponibilites')->find($dispoArticle);
				if($disponibilite->getReserved() == 1){
					$article->setDispo($disponibiliteDeBase[0]);
					$this->em->persist($article);
					$this->em->flush();	
				}
				//--------------------------------------------STOCK TEMPORAIRE--------------------------------------------------------------------
				$stocktemporaire = $article->getStocktemp();//---Récupération de l'id de l'entité StockTemp lié à l'article 
				$stockTempObject = $this->em->getRepository('GGBoutiqueBundle:StockTemp')->find($stocktemporaire);//---Récupération de l'entité StockTemp de l'article en BDD
				$valuestockTObject = $stockTempObject->getStocktemp();//--Récupération de sa valeur
				$newvalueStockTemp = $valuestockTObject + 1;//---Modification de la valeur du stocktemp de l'article
				$stockTempObject->setStocktemp($newvalueStockTemp);//--Attribution de la nouvelle valeur
				$this->em->persist($stockTempObject);
				$this->em->flush($stockTempObject);
				//-------------------------------------------------------------
				
			}
			//-------------------------------------------------------------------
			$panier->vider();
			return $this->redirectToRoute('gg_boutique_panier');			
		}

	}

