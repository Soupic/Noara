<?php

namespace AdminBundle\Service\DAO;

use AdminBundle\Exception\ArchitectureException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

/**
 * Class RacesDao
 * @package AdminBundle\Service\DAO
 */
class RacesDao extends AbstractMasterDAO
{
    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entity;
    }

    /**
     * @return ArrayCollection
     * @throws ArchitectureException
     */
    public function getAllRaces()
    {
        try {
            $repo = $this->entity->getRepository('AdminBundle:Races');

            $query = $repo->getAllRaces();

            return new ArrayCollection($query->getResult());
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Erreur lors de la récupération de la liste des races",
                "TODO",
                $exception
            );
        }
    }

    /**
     * @param int $idRaces
     * @return mixed
     * @throws ArchitectureException
     */
    public function getRaceById($idRaces)
    {
        try {
            $repo = $this->entity->getRepository("AdminBundle:Races");

            $query = $repo->getRaceById($idRaces);

            return $query->getSingleResult();
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Impossible de récupérer la races par son Id",
                "TODO",
                $exception
            );
        }
    }
}