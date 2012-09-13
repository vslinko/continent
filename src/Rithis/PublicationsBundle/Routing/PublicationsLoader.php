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
            'all' => '/%s',
        );

        foreach ($actions as $action => $route) {
            $route = new Route(sprintf($route, $resource), array(
                '_controller' => 'RithisPublicationsBundle:Publications:' . $action,
                'resource' => $resource,
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
