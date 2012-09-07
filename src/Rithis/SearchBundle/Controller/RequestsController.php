<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rithis\SearchBundle\Form\Type\QueryType;
use Elastica_ResultSet;

class RequestsController extends Controller
{
	public function newAction()
	{
		$form = $this->createForm(new QueryType());

		return $this->render('RithisSearchBundle:Requests:new.html.twig', array(
			'form' => $form->createView(),
		));
	}

	public function postAction()
	{
		$form = $this->createForm(new QueryType());
		$form->bind($this->getRequest());

		if ($form->isValid()) {
			$query = $form->getData()['query'];

			$results = $this->get('foq_elastica.index.rithis')->search($query);
			$groups = $this->groupResults($results);

			return $this->render('RithisSearchBundle:Requests:post.html.twig', array(
				'form' => $form->createView(),
				'results' => $results,
				'groups' => $groups,
				'query' => $query,
			));
		}

		return $this->render('RithisSearchBundle:Requests:new.html.twig', array(
			'form' => $form->createView(),
		));
	}

	private function groupResults(Elastica_ResultSet $results)
	{
		$groups = array();

		foreach ($results as $result) {
			$groups[$result->getType()][] = $result;
		}

		return $groups;
	}
}
