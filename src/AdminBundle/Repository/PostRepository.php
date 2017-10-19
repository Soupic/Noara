<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function getAllPost()
    {
        //Création du query Builder
        $qb = $this->createQueryBuilder("post");

        $qb
            ->select(
                "post",
                "media"
                )
            ->leftJoin("post.media", "media")
        ;

        return $qb->getQuery();
    }

    /**
     * @param $idPost
     * @return Query
     */
    public function getPostById($idPost)
    {
        //Création du query Builder
        $qb = $this->createQueryBuilder("post");
        //Requete qui récupère un post en fonction de son id
        $qb
            ->select(
                "post",
                "media"
                )
            ->leftJoin("post.media", "media")
            ->where($qb->expr()->eq("post.id", ":idPost"))
            ->setParameter("idPost", $idPost)
        ;

        return $qb->getQuery();
    }

    /**
     * @param int $isActivate
     * @return Query
     * Méthode de récupération de la liste des post actif
     */
    public function getCountEnablePost($isActivate)
    {
        $qb = $this->createQueryBuilder("post");

        $qb
            ->select("post")
            ->where($qb->expr()->eq("post.active", ":isActivate"))
            ->setParameter("isActivate", $isActivate)
        ;

        return $qb->getQuery();
    }

    /**
     * @param $isActivate
     * @return Query
     */
    public function getEnablePost($isActivate)
    {
        $qb = $this->createQueryBuilder("post");

        $qb
            ->addSelect(
                "post",
                "media"
            )
            ->leftJoin("post.media","media")
            ->where($qb->expr()->eq("post.active", ":isActivate"))
            ->setParameter('isActivate', $isActivate)
        ;

        return $qb->getQuery();
    }
}
