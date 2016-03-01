<?php

namespace Decibels\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Gedmo\Uploadable(filenameGenerator="SHA1", allowOverwrite=true)
 */
class File
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
     * @ORM\Column(name="path", type="string", length=255)
     * @Gedmo\UploadableFilePath
     */
    private $path;
    
    /**
     * @Assert\NotBlank()
     */
    private $file;

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
     * Set path
     *
     * @param string $path
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }
    
    public function getFile()
    {
        return $this->file;
    }
}
