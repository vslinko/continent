<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\PublicationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PublicationsController extends Controller
{
    public function allAction($resource, $template = 'RithisPublicationsBundle:Publications:all.html.twig', $limit = 10)
    {
        $em = $this->getDoctrine()->getManager();

        $count = $em
            ->createQuery('SELECT COUNT(p) FROM RithisPublicationsBundle:Publication p WHERE p.resource = :resource')
            ->setParameter('resource', $resource)
            ->getSingleScalarResult()
        ;

        $query = $em
            ->createQuery('SELECT p FROM RithisPublicationsBundle:Publication p WHERE p.resource = :resource')
            ->setParameter('resource', $resource)
            ->setHint('knp_paginator.count', $count)
        ;

        $pagination = $this->get('knp_paginator')->paginate(
            $query,
            $this->getRequest()->query->get('page', 1),
            $limit,
            array('distinct' => false)
        );

        return $this->render($template, array(
            'resource' => $resource,
            'pagination' => $pagination,
        ));
    }

    public function getAction($resource, $id, $template = 'RithisPublicationsBundle:Publications:get.html.twig')
    {
        $em = $this->getDoctrine()->getManager();

        $publication = $em->getRepository('RithisPublicationsBundle:Publication')->find(array(
            'id' => $id,
            'resource' => $resource,
        ));

        if (!$publication) {
            $this->createNotFoundException();
        }

        return $this->render($template, array(
            'resource' => $resource,
            'publication' => $publication,
        ));
    }

    public function render($view, array $parameters = array(), Response $response = null)
    {
        if (isset($parameters['resource'])) {
            $parameters['title'] = ucfirst($parameters['resource']);
            $parameters['publications_all'] = sprintf('publications_%s_all', $parameters['resource']);
            $parameters['publications_get'] = sprintf('publications_%s_get', $parameters['resource']);
        }

        return parent::render($view, $parameters, $response);
    }
}
