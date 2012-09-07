<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
	public function allAction()
	{
		$pagination = $this->get('knp_paginator')->paginate(
			$this->getDoctrine()->getManager()->createQuery("SELECT n FROM RithisNewsBundle:News n ORDER BY n.createdAt DESC"),
			$this->getRequest()->query->get('page', 1),
			10
		);

		return $this->render('RithisNewsBundle:News:all.html.twig', array(
			'pagination' => $pagination,
		));
	}

	public function getAction($slug)
	{
		$news = $this->getDoctrine()->getManager()->getRepository('RithisNewsBundle:News')->findOneBySlug($slug);

		if (!$news) {
			throw $this->createNotFoundException();
		}

		return $this->render('RithisNewsBundle:News:get.html.twig', array(
			'news' => $news,
		));
	}
}
