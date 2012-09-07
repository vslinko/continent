<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\NewsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class NewsAdmin extends Admin
{
	protected function configureListFields(ListMapper $mapper)
	{
		$mapper->addIdentifier('title');
		$mapper->add('createdAt');
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper->add('title');
		$mapper->add('createdAt');
		$mapper->add('updatedAt');
	}

	protected function configureFormFields(FormMapper $mapper)
	{
		$mapper->add('title');
		$mapper->add('description');
		$mapper->add('text');
	}
}
