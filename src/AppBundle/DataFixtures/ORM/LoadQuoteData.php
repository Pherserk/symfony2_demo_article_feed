<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Article;
use AppBundle\Entity\Quote;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadQuoteData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $quote1 = new Quote($this->getReference('user-2'), $this->getReference('article-1'), 'Amazing article guy!');
        $quote2 = new Quote($this->getReference('user-1'), $this->getReference('article-1'), 'Thank you dude!');

        $manager->persist($quote1);
        $manager->persist($quote2);

        $manager->flush();

        $this->addReference('quote-1', $quote1);
        $this->addReference('quote-2', $quote2);
    }

    public function getOrder()
    {
        return 20;
    }
}
