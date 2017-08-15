<?php

namespace PageBundle\Service\Persistance;


use Doctrine\ORM\EntityManager;
use PageBundle\Entity\Post;
use PageBundle\Exception\ArchitectureException;

/**
 * Class RacesPersistance
 * @package PageBundle\Service\Persistance
 */
class RacesPersistance
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

    public function saveRace(Races $race)
    {
        try {
            $this->entityManager->persist($race);
            $this->entityManager->flush();
        } catch ( \Exception $exception) {
            throw new ArchitectureException(
                "Impossible de sauvegarder la race",
                "TODO",
                $exception
            );
        }
    }
}