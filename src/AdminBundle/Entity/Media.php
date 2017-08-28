<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JMS\Serializer\Annotation as JMS;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\MediaRepository")
 */
class Media
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_media", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="url", length=255)
     */
    private $url;

    /**
     * @ORM\Column(name="alt", type="string", length=255)
     * @var string
     */
    private $alt;

    /**
     * @return mixed
     */
    private $file;

    // Attribut pour retenir le nom du fichier
    private $tempFileName;

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
    public function getId()
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
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @var UploadedFile
     * @param mixed $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        if (null !== $this->url) {
            $this->tempFileName = $this->url;

            $this->url = null;
            $this->alt =  null;
        }
    }

    /**
     * @ORM\PrePresist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;
        }

        $this->url = $this->file->guessExtension();

        $this->alr = $this->file->getCientOriginalName();
    }

    public function upload()
    {
        if (null === $this->file )
        {
            return;
        }

        if (null !== $this->tempFileName) {
            $oldFile = $this->getUploadRootDir()."/".$this->id.".".$this->tempFileName;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $this->file->move(
            $this->getUploadRootDir(),
            $this->id.".".$this->url
        );
    }

    public function preRemoveUpload()
    {
        $this->tempFileName = $this->getUploadRootDir()."/".$this->id.".".$this->url;
    }

    public function removeUpload()
    {
        if (file_exists($this->tempFileName)) {
            unlink($this->tempFileName);
        }
    }

    public function getUploadDir()
    {
        return "public/files";
    }

    protected function getUploadRootDir()
    {
        return __DIR__."/../../../web/".$this->getUploadDir();
    }

    public function getWebPath()
    {
        return $this->getUploadDir()."/".$this->getId().".".$this->getUrl();
    }

    /**
     * @return Collection
     */
    public function getCharacters()
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
    public function getRaces()
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
    public function getPost()
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

