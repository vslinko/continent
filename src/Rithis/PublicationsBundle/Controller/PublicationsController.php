<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\PublicationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
            'title' => ucfirst($resource),
            'pagination' => $pagination,
        ));
    }
}
