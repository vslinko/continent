<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\NewsBundle\Entity;

use DateTime;

class News
{
	protected $id;
	protected $slug;
	protected $title;
	protected $description;
	protected $text;
	protected $createdAt;
	protected $updatedAt;
	protected $deletedAt;

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setSlug($slug)
	{
		$this->slug = $slug;
	}

	public function getSlug()
	{
		return $this->slug;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setText($text)
	{
		$this->text = $text;
	}

	public function getText()
	{
		return $this->text;
	}

	public function setCreatedAt(DateTime $createdAt)
	{
		$this->createdAt = $createdAt;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function setUpdatedAt(DateTime $updatedAt)
	{
		$this->updatedAt = $updatedAt;
	}

	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	public function setDeletedAt(DateTime $deletedAt)
	{
		$this->deletedAt = $deletedAt;
	}

	public function getDeletedAt()
	{
		return $this->deletedAt;
	}
}
