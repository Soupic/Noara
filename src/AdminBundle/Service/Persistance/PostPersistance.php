<?php

namespace AdminBundle\Service\Persistance;

use AdminBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use AdminBundle\Exception\ArchitectureException;


/**
 * Class PostPersistance
 * @package AdminBundle\Service\Persistance
 */
class PostPersistance
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * PostPersistance constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Post $post
     * @throws ArchitectureException
     */
    public function savePost(Post $post)
    {
        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Impossible de sauvegarder le post",
                "TODO",
                $exception
            );
        }
    }

    /**
     * @param Post $post
     * @throws ArchitectureException
     */
    public function deletePost(Post $post)
    {
        try {
            $this->entityManager->remove($post);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Impossible de supprimer le post",
                "TODO",
                $exception
            );
        }
    }
}