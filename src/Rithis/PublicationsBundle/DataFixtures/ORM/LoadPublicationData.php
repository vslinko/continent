<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\PublicationsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rithis\PublicationsBundle\Entity\TextBlock;
use Rithis\PublicationsBundle\Entity\EmptyBlock;
use Rithis\PublicationsBundle\Entity\Publication;

class LoadPublicationData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $helloWorld = new TextBlock();
        $helloWorld->setText('Hello World!');
        $manager->persist($helloWorld);

        $empty = new EmptyBlock();
        $manager->persist($empty);

        $copyrights = new TextBlock();
        $copyrights->setText('2012 &copy; Rithis Studio LLC');
        $manager->persist($copyrights);

        $publication = new Publication();
        $publication->setId('good-news-everyone');
        $publication->setResource('news');
        $publication->setTitle('GOOD NEWS EVERYONE');
        $publication->addBlock($helloWorld);
        $publication->addBlock($empty);
        $publication->addBlock($copyrights);
        $manager->persist($publication);

        $manager->flush();
    }
}
