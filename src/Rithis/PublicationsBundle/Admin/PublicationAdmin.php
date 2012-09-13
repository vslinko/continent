<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\PublicationsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PublicationAdmin extends Admin
{
    protected $resource;

	protected function configureListFields(ListMapper $mapper)
	{
		$mapper->addIdentifier('id');
		$mapper->add('title');
	}

	protected function configureFormFields(FormMapper $mapper)
	{
		$mapper->add('id');
		$mapper->add('title');
	}

    public function prePersist($object)
    {
        $object->setResource($this->getResource());
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->andWhere('o.resource = :resource');
        $query->setParameter('resource', $this->getResource());

        return $query;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getClassnameLabel()
    {
        return $this->getResource();
    }
}
