<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\PublicationsBundle\Entity;

class TextBlock extends EmptyBlock
{
    protected $text;

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getType()
    {
        return 'text';
    }

    public function __toString()
    {
        return sprintf('<p>%s</p>', str_replace("\n\n", '</p><p>', $this->text));
    }
}
