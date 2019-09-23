<?php
namespace GG\PaiementBundle\Controller;	
use JMS\DiExtraBundle\Annotation as DI;
use JMS\Payment\CoreBundle\PluginController\Result;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GG\PaiementBundle\Entity\OrderPayment;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation\Inject;
use GG\PaiementBundle\Plugin\CreditCardPlugin;
use JMS\Payment\CoreBundle\PluginController\EntityPluginController;
use Doctrine\ORM\EntityManager;
use JMS\Payment\CoreBundle\PluginController\PluginController;
use JMS\Payment\CoreBundle\Entity\Payment;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use GG\BoutiqueBundle\Commande;


	

	class PaiementController extends Controller{
		public function __construct(){
			
			
			
		}
		
		
		private $request;

		
		private $router;

		/** @DI\Inject("paiement.plugin.paypal") */
		private $plugin;

		/** @DI\Inject("entity.plugin.controller") */
		private $epc;

		/** @DI\Inject("doctrine.orm.entity_manager") */
		private $em;

		/** @DI\Inject("payment.plugin_controller") */
		private $ppc;


		/**
		* @Route("/payer", name="gg_paiement_payer")
		* @Template()
		*/
		public function detailsAction(/*OrderPayment $orderpayement*/ Request $request){

			if($this->ppc != null);
			$this->ppc->addPlugin($this->plugin);
			
			//var_dump($this->plugin->processes('credit_card')) ;
			//$test = $this->container->get('payment.plugin_controller');
			$request = Request::createFromGlobals();
			$order= new OrderPayment;
			$order->setAmount(number_format(0, 2));
			//$this->em->persist( $order);
			//$this->em->flush();
			var_dump($order->getId());
			//$order->setId(72);
			//echo "<br>order_id : " . $order->getId();
			//echo "cURL command line version:<br><pre>";
			//echo `curl --version`;
			//echo "</pre>";
			$order->setAmount($this->get('session')->get('commande')->getMontantTTC());
			$config = array(
				'paypal_express_checkout' => array(
					'return_url' => 'https://www.rootsart.fr/boutique/panier/paiement/paiementcomplete/'.$order->getId(), 
					'cancel_url' => 'https://www.rootsart.fr/paiementcancel', array('id' =>$order->getId(), true)
					));
			$form = $this->createForm(ChoosePaymentMethodType::class, null, array(
				'amount'   => $order->getAmount(),
				'currency' => 'EUR',
				//'choice_label'=>array('style'=>'color:red'),
				'default_method'  => 'paypal_express_checkout',
				'allowed_methods' => ['paypal_express_checkout'],
				'predefined_data' => $config,
				'choice_options' => [
					'expanded' => false,
					
					],
				'method_options' => [
					'paypal_express_checkout' => [
						'label' => false,
					],
				],

				));

			//-----------------------Création de la Commande en BDD
				$user = $this->getUser();
				$panier = $this->get('session')->get('panier');
				$commande = new \GG\UserBundle\Entity\Commande($user, $panier);
				$commande->setOrder($order);
				$this->em->persist($commande);
				//$this->em->flush();
			//--------------------------------------------------------

			if ($request->isMethod('POST')){
				// $form->bind($request);
				$form->handleRequest($request);
				if ($form->isValid()) {
					$this->ppc->checkPaymentInstruction($instruction = $form->getData());//ok
					$this->ppc->createPaymentInstruction($instruction = $form->getData());//ok
					//$this->epc->createPaymentInstruction($instruction = $form->getData());
					//------------$this->epc->checkPaymentInstruction($instruction);

					$order->setPaymentInstruction($instruction = $form->getData());
					$this->ppc->checkPaymentInstruction($instruction = $form->getData());//ok
					//--------$this->epc->checkPaymentInstruction($instruction);//pas de message erreur sur getPlugin()
					
					$this->em->persist($order);
					$this->em->flush($order);

					

					return $this->redirectToRoute('payment_complete', array(
					'id' => $order->getId()));
				}
			}


			return $this->render('GGPaiementBundle:Paiement:paiement.html.twig', array(
			'form_paiement' => $form->createView(),
			'montant'=>$order->getAmount(),
			'id'=>$order->getId()));
    	}
    	public function completeAction($id){
    		//$this->epc->addPlugin($this->plugin);
    		$em = $this->getDoctrine()->getManager();
    		
    		
            	$order = $this->getDoctrine()->getRepository("GGPaiementBundle:OrderPayment")->find($id);
        	
			$instruction = $order->getPaymentInstruction();
			
			//echo $order->getPaymentInstruction()->getPaymentSystemName(); //marche bien

			if (null === $pendingTransaction = $instruction->getPendingTransaction()) {
				$payment = $this->ppc->createPayment($instruction->getId(), $instruction->getAmount() - $instruction->getDepositedAmount());
				//$test = new \JMS\Payment\CoreBundle\Entity\Payment($instruction);
				//$payment = $this->epc->createPayment($instruction->getId(), $instruction->getAmount() - $instruction->getDepositedAmount());
			} else {
				$payment = $pendingTransaction->getPayment();
			}
			$validation = $this->ppc->validatePaymentInstruction($instruction);//ok
			$transaction = $payment->getApproveTransaction();
			//$result = $this->epc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());
			$result = $this->ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());
			if (Result::STATUS_PENDING === $result->getStatus()) {
				$ex = $result->getPluginException();

				if ($ex instanceof ActionRequiredException) {
				$action = $ex->getAction();

				if ($action instanceof VisitUrl) {
				return new RedirectResponse($action->getUrl());
				}

				throw $ex;
				}
			} else if (Result::STATUS_SUCCESS !== $result->getStatus()) {
				echo ' status : ' . $result->getStatus(); 
				throw new \RuntimeException('Transaction was not successful: '.$result->getReasonCode());
			}
			// payment was successful, do something interesting with the order
			$content = $this->get('templating')->render('GGPaiementBundle:Paiement:succes.html.twig');
			return new Response($content);
			//return $this->redirectToRoute('paymentFull');
        
    }


    /**
     * @Route("/cancel", name = "payment_cancel")
     */
    public function CancelAction($id){
        $content = $this->get('templating')->render('GGPaiementBundle:Paiement:paiementCancel.html.twig');
		return new Response($content);
    }

     public function paymentSuccesAction(){
     	$content = $this->get('templating')->render('GGPaiementBundle:Paiement:succes.html.twig');
		return new Response($content);
    }

    protected function test(){
    	return  $this->container->get('payment.plugin_controller');	
    }
    // ...

    /** @DI\LookupMethod("form.factory") */
    protected function getFormFactory() { }


}

	