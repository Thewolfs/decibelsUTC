<?php
namespace Decibels\MembreBundle\Security\EntryPoint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class CasEntryPoint implements AuthenticationEntryPointInterface
{
	protected $loginPath;
	protected $checkPath;
	protected $httpUtils;
	
	public function __construct(HttpUtils $httpUtils, $loginPath, $checkPath)
	{
		$this->httpUtils = $httpUtils;
		$this->loginPath = $loginPath;
		$this->checkPath = $checkPath;
	}
	
	public function start(Request $request, AuthenticationException $authException = null)
	{
		$loginUrl = "https://cas.utc.fr/cas/login?service=".urlencode($request->getUriForPath($this->checkPath));
		
		$session = new Session;
		$session->set('url', $loginUrl);
		$session->set('compteur', 0);
		
		return $this->httpUtils->createRedirectResponse($request, $loginUrl);
	}
}
