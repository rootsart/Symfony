<?php
namespace  GG\BoutiqueBundle\Controller;
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
use GG\BoutiqueBundle\Entity\Recherche;
use GG\BoutiqueBundle\Form\RechercheType;
use Symfony\Component\HttpFoundation\JsonResponse;
use GG\BoutiqueBundle\Entity\StockTemp;
use JMS\DiExtraBundle\Annotation as DI;


class AdminBoutiqueController extends Controller{
		/** @DI\Inject("doctrine.orm.entity_manager") */
		private $em;

		
		/**
		* @Security("has_role('ROLE_ADMIN')")
		*/
		public function indexAdminAction(){
			return $this->render('GGBoutiqueBundle:AdminBoutique:adminBoutique.html.twig');


		}


		/**
		* @Security("has_role('ROLE_ADMIN')")
		*/
	    public function ajouterArticleAction(Request $request){
	        
			if ($request->isMethod('GET')){
				$session = $request->getSession();
			}

			$article = new Article();
			$form = $this->createForm(ArticleType::class, $article,  array('entity_manager' => $this->em));

				//Traitement du formulaire ne cas de POST
			if ($form->handleRequest($request)->isValid()) {
				$disponibiliteDeBase = $this->em->getRepository('GGBoutiqueBundle:Disponibilites')->findBase();
				$article->setDispo($disponibiliteDeBase[0]);//A la création d'un article, on lui attribut les disponibilités de base

				//---initialisatipn Stock Temporaire-------------
				$stock = $article -> getStock();
				$stocktemporaire = new StockTemp();
				$stocktemporaire->setStocktemp($stock);
				$article->setStocktemp($stocktemporaire);
				//--------------------------------

				$this->em = $this->getDoctrine()->getManager();
				$this->em->persist($article);
				$this->em->flush();
				return $this->redirect($this->generateUrl('gg_admin_ajout'));	
			}

			return $this->render('GGBoutiqueBundle:AdminBoutique:ajouterArticle.html.twig', array('form' => $form->createView())
			);	
	    }


		/**
		* @Security("has_role('ROLE_ADMIN')")
		*/
		public function modifierArticleAction(Request $request){
	    	
	    	$recherche = new Recherche();
			$form = $this->createForm(RechercheType::class, $recherche);
			return $this->render('GGBoutiqueBundle:AdminBoutique:formRecherche.html.twig', array('form'=>$form->createView()));
		}


		/**
		* @Security("has_role('ROLE_ADMIN')")
		*/
		public function formulaireModificationArticleAction(Request $request){
			$article = new Article();
			
				if($request->isXmlHttpRequest()){
					$id= $request->get('id');
					$this->get('session')->set('id_article', $id);				
					$rechercheArticle = $this->em->getRepository('GGBoutiqueBundle:Article')->find($id);
					if(!empty($rechercheArticle)){
						$form_article = $this->createForm(ArticleType::class, $rechercheArticle,  array('entity_manager' => $this->em));
						return new JsonResponse(array('success' => true, 'formarticle' => $this->renderView('GGBoutiqueBundle:AdminBoutique:formModificationArticle.html.twig',
                		array('formarticle' => $form_article->createView(), 'article'=>$rechercheArticle->getPhoto()->getUrl()))));
					}else{
							return new JsonResponse(array('success' => false, 'message'=>'aucun article correspondant à l\'id recherché'));
							}

				}

		}

		/**
		* @Security("has_role('ROLE_ADMIN')")
		*/
    	public function updateArticleFlushAction(Request $request){
    		if($request->isXmlHttpRequest()){
    				$photo = new Image();
    				$photo_url = $request->request->get('photo_url');
					$photo_alt = $request->request->get('photo_alt');
    				$photo -> setUrl($photo_url);
    				$photo -> setAlt($photo_alt);
    				

					$categorie = $request->request->get('categorie');
					$repository = $this
					->getDoctrine()
					->getManager()
					->getRepository('GGBoutiqueBundle:Categorie');
					$Entitecategorie = $repository->findByCategorie($categorie);

					$rubrique = $request->request->get('rubrique');
					$repository = $this
					->getDoctrine()
					->getManager()
					->getRepository('GGBoutiqueBundle:Rubriques');
					$Entiterubrique = $repository->findByRubrique($rubrique);

					$reference = $request->request->get('reference');
					$url = $request->request->get('url');
					$prix = $request->request->get('prix');
					$stock = $request->request->get('stock');
					$infos = $request->request->get('infos');
					$level = $request->request->get('level');
					
					/* Tableau à envoyer à la fonction Hydrate */
					$tab_update =array('categorie'=>$Entitecategorie[0], 'rubrique'=>$Entiterubrique[0], 'reference'=>$reference, 'url'=>$url, 'prix'=>$prix, 'stock'=>$stock, 'infos'=>$infos, 'level'=>$level, 'photo'=>$photo );
					
					/* On récupère l'id article mis en session */
					$id = $this->get('session')->get('id_article');

					/* Recherche de l'article à modifier via son Id */
					$article = $this->em->getRepository('GGBoutiqueBundle:Article')->find($id);

					/*** Hydratation de l'objet Article avec les données du formulaire modifié ***/
					if(!empty($article)){
						if($article->hydrate($tab_update)){
							$this->em->persist($article);
							$this->em->flush();
							return new JsonResponse(array('success' => true, 'message'=>'Update article ok '));
						}else{
								return new JsonResponse(array('success' => false, 'message'=>'Update article Nok'));
								}
					}
					
				
				
			}	
				
		}


		/**
		* @Security("has_role('ROLE_ADMIN')")
		*/
	    public function supprimerArticleAction(){
	        $content = $this->get('templating')->render('GGBoutiqueBundle:AdminBoutique:supprimerArticle.html.twig');
			return new Response($content);

	    }
}