<?php
	namespace GG\BoutiqueBundle\Controller;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use GG\BoutiqueBundle\Entity\Mail;
	
	class MailController extends Controller{

		public function mailAction(Request $request){
	    	if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
		    	if($request->isXmlHttpRequest()){
		    		$email = $request->get('mail');
		    		$sujet = $request->get('sujet');
		    		$text = $request->get('message');
		    		
		    		$message = \Swift_Message::newInstance()
			    		->setFrom($email)
			    		->setTo("contact@rootsart.fr")
						->setSubject($sujet)
						->setBody($text)
			        	->setContentType('text/html')	
			        	;
		        	/*****envoie du mail*******/
					$this->get('mailer')->send($message);
					//$request->getSession()->getFlashBag()->add('notice', 'Message sent!');
		    		$response =  new Response("mail envoyer");
		    		return $response;
		    	}
		    }else{
		    	$response =  new Response("Merci de vous connecter afin de nous contacter par mail .");
		    		return $response;
		    } 	
	    }


	    public function mailServiceAction(Request $request, $to, $text, $sujet){
			    	
	    	if($request->isXmlHttpRequest()){
	    		$to="";
	    		$email = "";
	    		$sujet = "";
	    		$text = "";

	    		$message = \Swift_Message::newInstance()
		    		->setFrom($email)
		    		->setTo($to)
					->setSubject($sujet)
					->setBody($text)
		        	->setContentType('text/html')	
		        	;
	        	//*****envoie du mail*******//
				$this->get('mailer')->send($message);
	    		$response =  new Response("mail envoyer");
	    		return $response;
	    	}
			    		    	
	    }
    }




