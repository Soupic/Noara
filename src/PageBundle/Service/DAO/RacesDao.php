<?php

namespace PageBundle\Service\DAO;

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
//        dump($repo);die();

        $query = $repo->getAllRaces();
    }
}