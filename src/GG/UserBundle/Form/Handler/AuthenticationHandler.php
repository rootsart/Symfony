<?php
namespace GG\UserBundle\Form\Handler;
use Symfony\Component\Routing\RouterInterface,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
    Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface,
    Symfony\Component\Security\Core\Exception\AuthenticationException,
    Symfony\Component\Security\Core\Authentication\Token\TokenInterface,
    Symfony\Component\HttpFoundation\JsonResponse;
  
class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    protected $router;
  
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
  
    public function onAuthenticationSuccess(Request $request, TokenInterface $token){
        if($request->isXmlHttpRequest()){
            $url = $this->router->generate('fos_user_profile_show');
            return new JsonResponse(array('success' => true, 'url'=>$url));
        }else{
            if ($token->getUser()->isSuperAdmin()) {
                return new RedirectResponse($this->router->generate('admin'));
            }
            else {
                return new RedirectResponse($this->router->generate('homepage'));
            }
        }
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception){
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array('success' => false, 'message' => '<span>' . $exception->getMessage() 
                . ' <br>Merci de vérifier vos identfiants, sinon vous n\'êtes peut être pas encore inscrit ? inscrivez vous !!!</span>'));
               // <a style="text-decoration:underline;font-size:14px;" href="{{path('"fos_user_registration_register"'}}"><i>inscription</i></a></p>'));
        } else {
            $request->get('session')->set(Security::AUTHENTICATION_ERROR, $exception);
            return new RedirectResponse($this->router->generate('fos_user_security_login'));
        }
    }
}
?>