<?php

namespace Decibels\MembreBundle;

use Decibels\MembreBundle\Security\Factory\CasFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DecibelsMembreBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		
		$extension = $container->getExtension('security');
		$extension->addSecurityListenerFactory(new CasFactory);
	}
}
