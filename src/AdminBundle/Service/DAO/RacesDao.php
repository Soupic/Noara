<?php

namespace AdminBundle\Service\DAO;

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

    public function getAllRaces()
    {
        $repo = $this->entity->getRepository('AdminBundle:Races');

        $query = $repo->getAllRaces();

        return new ArrayCollection($query->getResult());
    }
}