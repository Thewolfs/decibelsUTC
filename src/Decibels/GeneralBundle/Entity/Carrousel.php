<?php

namespace Decibels\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carrousel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Decibels\GeneralBundle\Entity\CarrouselRepository")
 */
class Carrousel
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
     * @var integer
     *
     * @ORM\Column(name="top", type="integer")
     */
    private $topClip;

    /**
     * @var integer
     *
     * @ORM\Column(name="bottom", type="integer")
     */
    private $bottomClip;

    /**
     * @var integer
     *
     * @ORM\Column(name="leftClip", type="integer")
     */
    private $leftClip;

    /**
     * @var integer
     *
     * @ORM\Column(name="rightClip", type="integer")
     */
    private $rightClip;

    /**
     * @var picture
     *
     * @ORM\OneToOne(targetEntity="Decibels\GeneralBundle\Entity\File")
     */
    private $picture;


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
     * Set top
     *
     * @param integer $top
     * @return Carrousel
     */
    public function setTopClip($topClip)
    {
        $this->topClip = $topClip;

        return $this;
    }

    /**
     * Get top
     *
     * @return integer 
     */
    public function getTopClip()
    {
        return $this->topClip;
    }

    /**
     * Set bottom
     *
     * @param integer $bottom
     * @return Carrousel
     */
    public function setBottomClip($bottomClip)
    {
        $this->bottomClip = $bottomClip;

        return $this;
    }

    /**
     * Get bottom
     *
     * @return integer 
     */
    public function getBottomClip()
    {
        return $this->bottomClip;
    }

    /**
     * Set leftClip
     *
     * @param integer $leftClip
     * @return Carrousel
     */
    public function setLeftClip($leftClip)
    {
        $this->leftClip = $leftClip;

        return $this;
    }

    /**
     * Get leftClip
     *
     * @return integer 
     */
    public function getLeftClip()
    {
        return $this->leftClip;
    }

    /**
     * Set rightClip
     *
     * @param integer $rightClip
     * @return Carrousel
     */
    public function setRightClip($rightClip)
    {
        $this->rightClip = $rightClip;

        return $this;
    }

    /**
     * Get rightClip
     *
     * @return integer 
     */
    public function getRightClip()
    {
        return $this->rightClip;
    }

    /**
     * Set picture
     *
     * @param \Decibels\GeneralBundle\Entity\File $picture
     * @return Carrousel
     */
    public function setPicture(\Decibels\GeneralBundle\Entity\File $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \Decibels\GeneralBundle\Entity\File 
     */
    public function getPicture()
    {
        return $this->picture;
    }
}
