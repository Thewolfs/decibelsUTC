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
     * @ORM\Column(name="leftClip", type="integer")
     */
    private $leftClip;

    /**
     * @var picture
     *
     * @ORM\OneToOne(targetEntity="Decibels\GeneralBundle\Entity\File")
     */
    private $picture;
    
     /**
     * @var integer
     *
     * @ORM\Column(name="zoom", type="integer")
     */
    private $zoom;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

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

    /**
     * Set zoom
     *
     * @param integer $zoom
     * @return Carrousel
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * Get zoom
     *
     * @return integer 
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Carrousel
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
}
