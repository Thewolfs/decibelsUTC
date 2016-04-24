<?php
namespace Decibels\UserBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

class CasUser implements UserInterface
{
	private $username;
	private $password;
	private $salt;
	private $roles;
	private $displayName;
	private $roleAsso;
	
	
	public function __construct($username, array $roles, $roleAsso)
	{
		$this->username = $username;
		$this->password = md5(uniqid($username, true));
		$this->salt = null;
		$this->roles = $roles;
		$this->roleAsso = $roleAsso;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function getSalt()
	{
		return $this->salt;
	}
	
	public function getRoles()
	{
		return $this->roles;
	}
	
	public function getDisplayName()
	{
		return $this->displayName;
	}
	
	public function getRoleAsso()
	{
		return $this->roleAsso;
	}
	
	public function eraseCredentials()
    {
    }

	public function equals(UserInterface $user)
	{
		if(!user instanceof CasUser)
		{
			return false;
		}
		
		if($this->username !== $user->getUsername())
		{
			return false;
		}
		
		if($this->displayName !== $user->getDisplayName())
		{
			return false;
		}
		
		return true;
	}
}
