<?php

namespace AdminBundle\Service\DAO;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use AdminBundle\Exception\ArchitectureException;


/**
 * Class PostDao
 * @package AdminBundle\Service\DAO
 */
class PostDao extends AbstractMasterDAO
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
    public function getAllPost()
    {
        try {//On récupère le bon répository
            $repo = $this->entity->getRepository("AdminBundle:Post");
            //Appel à la méhtode du répo pour nous retourné tout les posts
            $query = $repo->getAllPost();
            //Nous retourne une tableau de collection avec le résulta
            return new ArrayCollection($query->getResult());
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Erreur lors de la récupération des posts",
                "TODO",
                $exception
            );
        }
    }
}