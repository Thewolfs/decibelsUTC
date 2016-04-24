<?php
namespace Decibels\UserBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class CasToken extends AbstractToken
{
	private $credentials;
	
	public function __construct($ticket, array $roles = array())
	{
		parent::__construct($roles);
		
		$this->credentials = $ticket;
	}
	
	public function getCredentials()
	{
		return $this->credentials;
	}
}
