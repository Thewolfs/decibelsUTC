<?php

namespace Decibels\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carrousel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Decibels\CommonBundle\Entity\CarrouselRepository")
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
     * @ORM\OneToOne(targetEntity="Decibels\CommonBundle\Entity\File")
     * @ORM\JoinColumn(name="picture_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $picture;
    
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
     * @param \Decibels\CommonBundle\Entity\File $picture
     * @return Carrousel
     */
    public function setPicture(\Decibels\CommonBundle\Entity\File $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \Decibels\CommonBundle\Entity\File 
     */
    public function getPicture()
    {
        return $this->picture;
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
