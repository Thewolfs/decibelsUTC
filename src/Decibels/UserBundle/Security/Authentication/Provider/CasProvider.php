<?php
namespace Decibels\UserBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Decibels\UserBundle\Security\Authentication\Token\CasToken;
use Decibels\UserBundle\Security\User\CasUser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CasProvider implements AuthenticationProviderInterface
{
	private $userProvider;
	private $checkPath;
	private $requestStack;
	
	public function __construct(UserProviderInterface $userProvider, $checkPath, RequestStack $requestStack)
	{
		$this->userProvider = $userProvider;
		$this->checkPath = $checkPath;
		$this->requestStack = $requestStack;
	}
	
	public function authenticate(TokenInterface $token)
	{	
		if($crawler = $this->validateToken($token))
		{
			$user = $token->getUser();
			
			if($user instanceof CasUser)
			{
				return $token;
			}
			
			
			if($crawler->first()->children()->first()->children()->first()->children()->first()->getNode(0)->tagName != 'authenticationsuccess')
			{
				throw new AuthenticationException('The CAS authentication failed');
			}
			$user = $this->userProvider->loadUserByUsername($crawler->first()->children()->first()->children()->first()->children()->first()->children()->first()->text());
			$authenticatedToken = new CasToken('', $user->getRoles());
			$authenticatedToken->setUser($user);
			
			return $authenticatedToken;
		}
		
		throw new AuthenticationException('The CAS authentication failed');
	}
	
	protected function validateToken(CasToken $token)
	{
		$request = $this->requestStack->getCurrentRequest();
		$url = "https://cas.utc.fr/cas/serviceValidate?ticket=".$token->getCredentials().'&service='.$request->getUriForPath($this->checkPath);
		$validation = file_get_contents($url);
		if($validation)
		{
			return new Crawler($validation);
		}
		return false;
	}
	
	public function supports(TokenInterface $token)
    {
        return $token instanceof CasToken;
    }
}
