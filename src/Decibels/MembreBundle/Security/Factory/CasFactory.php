<?php
namespace Decibels\MembreBundle\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class CasFactory implements SecurityFactoryInterface
{
	public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
	{
		$providerId = 'security.authentication.provider.cas.'.$id;
		$container	
				->setDefinition($providerId, new DefinitionDecorator('cas.security.authentication.provider'))
				->replaceArgument(0, new Reference($userProvider))
				->replaceArgument(1, $config['check_path']);
				
		$listenerId = 'security.authentication.listener.cas.'.$id;
		$container->setDefinition($listenerId, new DefinitionDecorator('cas.security.authentication.listener'));
		
		return array($providerId, $listenerId, $defaultEntryPoint);
	}
	
	public function getPosition()
	{
		return 'pre_auth';
	}
	
	public function getKey()
	{
		return 'cas';
	}
	
	public function addConfiguration(NodeDefinition $node)
	{
		$node
			->children()
			->scalarNode('check_path')
			->end()
			->scalarNode('login_path')
			->end();
	}
}
