<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\NewsBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class RithisNewsExtension extends Extension
{
	public function load(array $configs, ContainerBuilder $container)
	{
		$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.yml');
	}
}
