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

    const NAME_REPO = "AdminBundle:Post";

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
            $repo = $this->entity->getRepository(self::NAME_REPO);
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

    /**
     * @param int $idPost
     * @return mixed
     * @throws ArchitectureException
     */
    public function getPostById($idPost)
    {
        try {
            //Appel du répository
            $repo = $this->entity->getRepository(self::NAME_REPO);
            //Appel de la méthode de reherche par l'ID
            $query = $repo->getPostById($idPost);
            //Retourne le simple résultat
            return $query->getSingleResult();
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Impossible de récupéré le post par son ID",
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
    public function getCountEnablePoste($isActivate)
    {
        try {
            //On appel le répository
            $repo = $this->entity->getRepository(self::NAME_REPO);

            $query = $repo->getCountEnablePost($isActivate);

            return new ArrayCollection($query->getResult());
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Impossible de récupérer la liste des post actif",
                "TODO",
                $exception
            );
        }

    }

    /**
     * @param $isActivate
     * @return ArrayCollection
     * @throws ArchitectureException
     */
    public function getEnablePost($isActivate)
    {
        try {
            $repo = $this->entity->getRepository(self::NAME_REPO);

            $query = $repo->getEnablePost($isActivate);

            return new ArrayCollection($query->getResult());
        } catch ( _Exception $exception) {
            throw new ArchitectureException(
                "Impossible de récupérer la liste des post activé, avec leurs images",
                "TODO",
                $exception
            );
        }
    }
}