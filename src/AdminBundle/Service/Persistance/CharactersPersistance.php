<?php

namespace AdminBundle\Service\Persistance;

use AdminBundle\Entity\Characters;
use Doctrine\ORM\EntityManager;
use AdminBundle\Exception\ArchitectureException;

/**
 * Class CharactersPersistance
 * @package AdminBundle\Service\Persistance
 */
class CharactersPersistance
{
    /** @var  EntityManager */
    private $entityManager;

    /**
     * RacesPersistance constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Characters $characters
     * @throws ArchitectureException
     */
    public function saveRace(Characters $characters)
    {
        try {
            $this->entityManager->persist($characters);
            $this->entityManager->flush();
        } catch ( \Exception $exception) {
            throw new ArchitectureException(
                "Impossible de sauvegarder le personnage",
                "TODO",
                $exception
            );
        }
    }

    /**
     * @param Characters $characters
     * @throws ArchitectureException
     */
    public function deletedRace(Characters $characters)
    {
        try {
            $this->entityManager->remove($characters);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Impossible de supprimer la race",
                "TODO",
                $exception
            );
        }
    }
}