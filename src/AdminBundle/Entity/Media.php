<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use SDVI\Core\CommonBundle\Interfaces\FileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\MediaRepository")
 * @Vich\Uploadable
 */
class Media
{
    const REGEX = "/[\/\\\]+/";

    const FORMAT_IMG_ALLOWED = ["jpeg", "png"];

    /**
     * @var int
     *
     * @ORM\Column(name="id_media", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="media", fileNameProperty="mediaFileName")
     * @var File
     */
    private $mediaFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $mediaName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Characters", mappedBy="media")
     */
    private $characters;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Races", mappedBy="media")
     */
    private $races;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Post", mappedBy="media")
     */
    private $post;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return File
     */
    public function getMediaFile(): File
    {
        return $this->mediaFile;
    }

    /**
     * @param File $mediaFile
     * @return $this
     */
    public function setMediaFile(File $mediaFile)
    {
        $this->mediaFile = $mediaFile;

        if ($mediaFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getMediaName(): string
    {
        return $this->mediaName;
    }

    /**
     * @param string $mediaName
     */
    public function setMediaName(string $mediaName)
    {
        $this->mediaName = $mediaName;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return Collection
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    /**
     * @param Collection $characters
     */
    public function setCharacters(Collection $characters)
    {
        $this->characters = $characters;
    }

    /**
     * @return Collection
     */
    public function getRaces(): Collection
    {
        return $this->races;
    }

    /**
     * @param Collection $races
     */
    public function setRaces(Collection $races)
    {
        $this->races = $races;
    }

    /**
     * @return Collection
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    /**
     * @param Collection $post
     */
    public function setPost(Collection $post)
    {
        $this->post = $post;
    }


}

