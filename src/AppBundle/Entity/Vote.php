<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Tests\Fixtures\Author;


/**
 * @ORM\Entity
 * @ORM\Table(name="vote")
 */
class Vote
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $article;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate;

    /**
     * Vote constructor.
     * @param User $author
     * @param Article $article
     * @param int $rate
     */
    public function __construct(User $author, Article $article, $rate)
    {
        $this->author = $author;
        $this->article = $article;
        $this->rate = $rate;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @return int
     */
    public function getRate()
    {
        return $this->rate;
    }
}

