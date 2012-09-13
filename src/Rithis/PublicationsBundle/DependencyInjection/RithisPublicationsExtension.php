<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\PublicationsBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Definition;

class RithisPublicationsExtension extends Extension
{
	public function load(array $configs, ContainerBuilder $container)
	{
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

		$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.yml');

        foreach ($config as $resource => $resourceConfig) {
            $definition = new Definition('Rithis\\PublicationsBundle\\Admin\\PublicationAdmin', array(
                null,
                'Rithis\\PublicationsBundle\\Entity\\Publication',
                'SonataAdminBundle:CRUD'
            ));

            $definition->addMethodCall('setResource', array($resource));
            $definition->addMethodCall('setTranslationDomain', array('rithis_publications'));

            $definition->addTag('sonata.admin', array(
                'manager_type' => 'orm',
                'group' => 'Publications',
                'label' => ucfirst($resource)
            ));

            $container->setDefinition(sprintf('rithis.publications.admin.%s', $resource), $definition);
        }
	}
}
