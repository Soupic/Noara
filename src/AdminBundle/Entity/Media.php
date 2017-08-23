<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use SDVI\Core\CommonBundle\Interfaces\FileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\MediaRepository")
 */
class Media implements FileInterface
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
     * @Assert\File(
     *     mimeTypes={"image/jpeg", "image/png", "application/pdf"},
     *     mimeTypesMessage = "format autorisés : .jpeg, .png, .pdf"
     * )
     */
    private $nonUploadedFile;

    /**
     * @var bool
     *
     * @ORM\Column(name="safe_delete", type="boolean")
     */
    private $safeDelete = false;

    /**
     * @var string
     *
     * @ORM\Column(name="asset_path", type="string", length=255)
     */
    private $assetPath;

    /**
     * @var int
     * @Assert\Type("integer")
     *
     * @ORM\Column(name="root_dir_enum", type="integer", nullable=false)
     */
    private $rootDirEnum;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="orignial_name", type="string", length=255)
     */
    private $originalName;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=10, unique=true)
     */
    private $type;

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
     * @return mixed
     */
    public function getNonUploadedFile()
    {
        return $this->nonUploadedFile;
    }

    /**
     * @param UploadedFile $nonUploadedFile
     */
    public function setNonUploadedFile(UploadedFile $nonUploadedFile)
    {
        $this->nonUploadedFile = $nonUploadedFile;
    }

    /**
     * @return bool
     */
    public function isSafeDelete(): bool
    {
        return $this->safeDelete;
    }

    /**
     * @param bool $safeDelete
     */
    public function setSafeDelete(bool $safeDelete)
    {
        $this->safeDelete = $safeDelete;
    }

    /**
     * @return string
     */
    public function getAssetPath(): string
    {
        return $this->assetPath;
    }

    /**
     * @param string $assetPath
     */
    public function setAssetPath(string $assetPath)
    {
        $this->assetPath = $assetPath;
    }

    /**
     * @return int
     */
    public function getRootDirEnum(): int
    {
        return $this->rootDirEnum;
    }

    /**
     * @param int $rootDirEnum
     */
    public function setRootDirEnum(int $rootDirEnum)
    {
        $this->rootDirEnum = $rootDirEnum;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName)
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
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

