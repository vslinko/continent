<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\PublicationsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Publication
{
    protected $id;
    protected $resource;
    protected $title;
    protected $blocks;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function addBlock(EmptyBlock $block)
    {
        $block->setPublication($this);
        $this->blocks[] = $block;
    }

    public function removeBlock(EmptyBlock $block)
    {
        $this->blocks->remove($block);
    }

    public function getBlocks()
    {
        return $this->blocks;
    }

    public function getBlocksBeforeEmpty()
    {
        $blocks = array();

        foreach ($this->blocks as $block) {
            if (get_class($block) == __NAMESPACE__ . '\\EmptyBlock') {
                break;
            }

            $blocks[] = $block;
        }

        return $blocks;
    }
}
