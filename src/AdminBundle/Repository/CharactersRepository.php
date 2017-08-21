<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CharactersRepository
 * @package AdminBundle\Repository
 */
class CharactersRepository extends EntityRepository
{
    public function getAllCharacters()
    {
        //Création du query Builder
        $qb = $this->createQueryBuilder("characters");

        //Requete permétant de trouvé tous les personnages
        $qb
            ->select("characters")
        ;

        return $qb->getQuery();
    }
}
