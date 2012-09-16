<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\PublicationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Rithis\PublicationsBundle\Entity\EmptyBlock;
use Rithis\PublicationsBundle\Entity\TextBlock;

class PublicationsController extends Controller
{
    public function editAction($resource, $id, $template = 'RithisPublicationsBundle:Publications:edit.html.twig')
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            //throw $this->createNotFoundException();
        }

        $publication = $this->getPublication($id, $resource);

        return $this->render($template, array(
            'resource' => $resource,
            'publication' => $publication,
        ));
    }

    public function putAction($resource, $id)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            //throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();

        foreach ($em->getEventManager()->getListeners() as $event => $listeners) {
            foreach ($listeners as $listener) {
                if ($listener instanceof \Gedmo\Sortable\SortableListener) {
                    $em->getEventManager()->removeEventListener($event, $listener);
                }
            }
        }

        $publication = $this->getPublication($id, $resource);

        foreach ($publication->getBlocks() as $block) {
            $em->remove($block);
        }

        $em->flush();

        $publicationContent = json_decode($this->getRequest()->getContent());

        $publication->setTitle($publicationContent->title);

        foreach ($publicationContent->blocks as $i => $blockContent) {
            switch ($blockContent->type) {
                case 'empty':
                    $block = new EmptyBlock();
                    $block->setPosition($i);
                    $publication->addBlock($block);
                    break;
                case 'text':
                    $block = new TextBlock();
                    $block->setText($blockContent->content);
                    $block->setPosition($i);
                    $publication->addBlock($block);
                    break;
            }
        }

        $em->flush();

        return new Response(json_encode(array('status' => 'ok')));
    }

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
        $publication = $this->getPublication($id, $resource);

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
            $parameters['publications_put'] = sprintf('publications_%s_put', $parameters['resource']);
        }

        return parent::render($view, $parameters, $response);
    }

    public function getPublication($id, $resource)
    {
        $em = $this->getDoctrine()->getManager();

        $publication = $em->getRepository('RithisPublicationsBundle:Publication')->find(array(
            'id' => $id,
            'resource' => $resource,
        ));

        if (!$publication) {
            $this->createNotFoundException();
        }

        return $publication;
    }
}
