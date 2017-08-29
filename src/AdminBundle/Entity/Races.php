<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\Collection;
use AdminBundle\Entity\Media;

/**
 * Races
 *
 * @ORM\Table(name="races")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\RacesRepository")
 */
class Races
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_races", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var Characters
     * @JMS\Type("AdminBundle\Entity\Characters")
     * @ORM\ManyToOne(targetEntity="Characters", inversedBy="races")
     * @ORM\JoinColumn(name="characters_id", referencedColumnName="id_characters")
     */
    private $characters;

    /**
     * @var Media
     * @JMS\Type("AdminBundle\Entity\Media")
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="races", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id_media")
     */
    private $media;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Races
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Races
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Races
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @param int $characters
     */
    public function setCharacters($characters)
    {
        $this->characters = $characters;
    }

    /**
     * @return int
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param int $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }
}

