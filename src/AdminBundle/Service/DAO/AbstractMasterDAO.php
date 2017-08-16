<?php

namespace AdminBundle\Service\DAO;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractMasterDAO
 * @package EntitiesServerBundle\Service
 */
abstract class AbstractMasterDAO
{
    /**
     * @var EntityManager
     */
    protected $entity;

    /**
     * MasterService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entity = $entityManager;
    }

//    /**
//     * @return EntityRepository
//     */
//    protected function getRepository($name)
//    {
//        return $this->entity->getRepository($name);
//    }
//
//    /**
//     * @return string ex: AcmeBundle:EntityName
//     */
//    abstract protected function getRepositoryAliasName();
}