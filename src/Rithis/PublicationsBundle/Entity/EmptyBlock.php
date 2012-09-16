<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\PublicationsBundle\Entity;

class EmptyBlock
{
    protected $id;
    protected $publication;
    protected $position = 0;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPublication(Publication $publication)
    {
        $this->publication = $publication;
    }

    public function getPublication()
    {
        return $this->publication;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getType()
    {
        return 'empty';
    }

    public function __toString()
    {
        return '';
    }
}
