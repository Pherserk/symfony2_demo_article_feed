<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Article;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article1 = new Article($this->getReference('user-1'), 'Title of article 1', 'Text of article 1');
        $article2 = new Article($this->getReference('user-1'), 'Title of article 2', 'Text of article 2');

        $manager->persist($article1);
        $manager->persist($article2);

        $manager->flush();

        $this->addReference('article-1', $article1);
        $this->addReference('article-2', $article2);
    }

    public function getOrder()
    {
        return 10;
    }
}
