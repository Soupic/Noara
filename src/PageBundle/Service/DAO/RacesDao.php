<?php

namespace PageBundle\Service\DAO;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

/**
 * Class RacesDao
 * @package PageBundle\Service\DAO
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
        $repo = $this->entity->getRepository('PageBundle:Races');

        $query = $repo->getAllRaces();

        return new ArrayCollection($query->getResult());
    }
}