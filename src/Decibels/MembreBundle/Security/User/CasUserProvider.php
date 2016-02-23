<?php
namespace Decibels\MembreBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class CasUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
		$listMembres = json_decode(file_get_contents('http://assos.utc.fr/asso/membres.json/decibels'));
		
		$membre = null;
		foreach($listMembres as $struct) {
			if ($username == $struct->login) {
				$membre = $struct;
				break;
			}
		}
        if ($membre) 
		{
			if($membre->bureau)
			{
				$roles = array('ROLE_ADMIN');
			}				
			else
			{
				$roles = array('ROLE_MEMBRE');
			}
			return new CasUser($username, $roles, $membre->role);
        }
		$roles = array('ROLE_USER');
		return new CasUser($username, $roles, "Utilisateur");
		
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof CasUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $user;
    }

    public function supportsClass($class)
    {
        return $class === 'Decibels\MembreBundle\Security\User\CasUser';
    }
}
