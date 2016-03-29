<?php

namespace Decibels\MembreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function loginAction(Request $request)
    {
		$loginUrl = "https://cas.utc.fr/cas/login?service=http://".$request->server->get('HTTP_HOST').$this->get('router')->generate('decibels_login_check');
		
		return $this->redirect($loginUrl);
	}
	
	public function logoutAction(Request $request)
	{		
		$session = $request->getSession();
		$session->clear();
		$this->container->get('security.context')->setToken(null);
		
		return $this->redirect('https://cas.utc.fr/cas/logout?service=http://'.$request->server->get('HTTP_HOST').$this->get('router')->generate('decibels_homepage'));
	}
	
	public function loginCheckAction(Request $request)
	{
		$request->getSession()->set('panier', array());
		$request->getSession()->set('lastConnexion', $request->cookies->get('lastConnexion'));
		
		$url = $this->get('router')->generate('decibels_homepage');
		
		
		$response = new Response();
		$dateCo = date('Y-m-d H:i:s');
		$request->getSession()->set('test', $dateCo);
		$response->headers->setCookie(new Cookie('lastConnexion', $dateCo , time() + 3600 * 24 * 7, '/', null, false, false));
		$response->sendHeaders();
		return $this->redirect($url);
	}
}
