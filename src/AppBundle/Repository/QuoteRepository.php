<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Quote;
use Doctrine\ORM\EntityRepository;

class QuoteRepository extends EntityRepository
{
    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return Quote[]
     */
    public function findByCreationBeetween(\DateTime $from, \DateTime $to)
    {
        $qb = $this->createQueryBuilder('Quote');

        $qb
            ->andWhere($qb->expr()->between('Quote.creation', ':from', ':to'))
            ->setParameters(['from' => $from, 'to' => $to]);

        return $qb->getQuery()->getResult();
    }
}
