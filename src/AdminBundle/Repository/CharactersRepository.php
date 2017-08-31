<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class CharactersRepository
 * @package AdminBundle\Repository
 */
class CharactersRepository extends EntityRepository
{
    /**
     * @return Query
     */
    public function getAllCharacters()
    {
        //Création du query Builder
        $qb = $this->createQueryBuilder("characters");

        //Requete permétant de trouvé tous les personnages
        $qb
            ->select(
                "characters",
                "media"
                )
            ->leftJoin("characters.media", "media")
        ;

        return $qb->getQuery();
    }

    /**
     * @param int $idCharacters
     * @return Query
     */
    public function getCharactersById($idCharacters)
    {
        //Création du queryBuilder
        $qb = $this->createQueryBuilder("characters");

        //Récupération du personnage gràce à l'id
        $qb
            ->select(
                "characters",
                "media"
                )
            ->leftJoin("characters.media", "media")
            ->where($qb->expr()->eq("characters.id", ":idCharacters"))
            ->setParameter("idCharacters", $idCharacters)
        ;
        //Retour de la requete
        return $qb->getQuery();
    }
}
