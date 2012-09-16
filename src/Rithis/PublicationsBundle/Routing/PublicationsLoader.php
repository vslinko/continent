<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\PublicationsBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class PublicationsLoader implements LoaderInterface
{
    public function load($resource, $type = null)
    {
        $collection = new RouteCollection();

        $actions = array(
            'edit' => array('url' => '/%s/{id}/edit', 'method' => 'GET'),
            'put' => array('url' => '/%s/{id}', 'method' => 'PUT'),
            'get' => array('url' => '/%s/{id}', 'method' => 'GET'),
            'all' => array('url' => '/%s', 'method' => 'GET'),
        );

        foreach ($actions as $action => $route) {
            $route = new Route(sprintf($route['url'], $resource), array(
                '_controller' => 'RithisPublicationsBundle:Publications:' . $action,
                'resource' => $resource,
            ), array(
                '_method' => $route['method'],
            ));

            $collection->add(sprintf("publications_%s_%s", $resource, $action), $route);
        }

        return $collection;
    }

    public function supports($resource, $type = null)
    {
        return 'publications' === $type;
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {
    }

    public function getResolver()
    {
    }
}
