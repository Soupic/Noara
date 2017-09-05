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
    const NAME_REPO = "AdminBundle:Races";

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
            $repo = $this->entity->getRepository(self::NAME_REPO);

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
            $repo = $this->entity->getRepository(self::NAME_REPO);

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

    /**
     * @param int $isActivate
     * @return ArrayCollection
     * @throws ArchitectureException
     */
    public function getCountEnableRace($isActivate)
    {
        try {
            //On appel le répo concerné
            $repo = $this->entity->getRepository(self::NAME_REPO);
            //On va chercher la méthode voulu
            $query = $repo->getCountEnableRace($isActivate);
            //On retourne la requete
            return new ArrayCollection($query->getResult());
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Impossible de récupérer la liste des races active",
                "TODO",
                $exception
            );
        }
    }
}