<?php
namespace Decibels\MembreBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Decibels\MembreBundle\Security\Authentication\Token\CasToken;


class CasListener implements ListenerInterface
{
	protected $tokenStorage;
	protected $authentificationManager;
	
	public function __construct(TokenStorageInterface $securityContext, AuthenticationManagerInterface $authenticationManager)
	{
		$this->securityContext = $securityContext;
		$this->authenticationManager = $authenticationManager;
	}
	
	public function handle(GetResponseEvent $event)
	{
		$request = $event->getRequest();
		
		if(!$request->query->get('ticket'))
		{
			return;
		}
		$token = new CasToken($request->query->get('ticket'));
		try
		{
			$authToken = $this->authenticationManager->authenticate($token);
			$authToken->setAuthenticated(true);
			
			$this->securityContext->setToken($authToken);
		}
		catch(AuthenticationException $failed)
		{
			$this->securityContext->setToken(null);
			
			$response = new Response();
			$response->setStatusCode(403);
			$event->setResponse($response);
		}
	}
}
