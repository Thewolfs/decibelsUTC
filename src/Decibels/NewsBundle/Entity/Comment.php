<?php

namespace Decibels\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Decibels\NewsBundle\Entity\CommentRepository")
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

	/**
	 * @var \string
	 *
	 * @ORM\Column(name="author", type="string", length=255)
	 */
	private $author;
	
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Decibels\NewsBundle\Entity\News", inversedBy="comments")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $news;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Commentary
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Commentary
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set news
     *
     * @param \Decibels\NewsBundle\Entity\News $news
     * @return Comment
     */
    public function setNews(\Decibels\NewsBundle\Entity\News $news)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \Decibels\NewsBundle\Entity\News 
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
