<?php

namespace Decibels\UserBundle;

use Decibels\UserBundle\Security\Factory\CasFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DecibelsUserBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		
		$extension = $container->getExtension('security');
		$extension->addSecurityListenerFactory(new CasFactory);
	}
}
