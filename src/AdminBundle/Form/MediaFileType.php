<?php

namespace AdminBundle\Form\MediaFileType;


use SDVI\Core\CommonBundle\Service\File\FileService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class MediaFileType
 * @package AdminBundle\Form\MediaFileType
 */
class MediaFileType extends AbstractType
{
    /**
     * @var FileService
     */
    private $fileService;

    /**
     * MediaFileType constructor.
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                ""
            )
    }
}