<?php

namespace AdminBundle\Service\Persistance;


use Doctrine\ORM\EntityManager;
use AdminBundle\Entity\Races;
use AdminBundle\Exception\ArchitectureException;

/**
 * Class RacesPersistance
 * @package AdminBundle\Service\Persistance
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

    /**
     * @param Races $race
     * @throws ArchitectureException
     */
    public function saveRace(Races $race)
    {
//        try {
            $this->entityManager->persist($race);
            $this->entityManager->flush();
////        } catch ( \Exception $exception) {
//            throw new ArchitectureException(
//                "Impossible de sauvegarder la race",
//                "TODO",
//                $exception
//            );
//        }
    }

    /**
     * @param Races $races
     * @throws ArchitectureException
     */
    public function deletedRace(Races $races)
    {
        try {
            $this->entityManager->remove($races);
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