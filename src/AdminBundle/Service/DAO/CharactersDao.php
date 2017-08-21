<?php

namespace AdminBundle\Service\DAO;

use AdminBundle\Exception\ArchitectureException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;


/**
 * Class CharactersDao
 * @package AdminBundle\Service\DAO
 */
class CharactersDao extends AbstractMasterDAO
{
    //Constante de nom de repo
    const NAME_REPO = "AdminBundle:Characters";

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
    public function getAllCharacters()
    {
        try {
            //Appel du répo characters
            $repo = $this->entity->getRepository(self::NAME_REPO);
            //Récupération de le requete
            $query = $repo->getAllCharacters();
            //Retourne une collection de personnages
            return new ArrayCollection($query->getArrayResult());
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Impossible de récupéré la liste des personnages",
                "TODO",
                $exception
            );
        }
    }

    /**
     * @param int $idCharacters
     * @return mixed
     * @throws ArchitectureException
     */
    public function getRaceById($idCharacters)
    {
        try {
            $repo = $this->entity->getRepository(self::NAME_REPO);

            $query = $repo->getCharactersById($idCharacters);

            return $query->getSingleResult();
        } catch (\Exception $exception) {
            throw new ArchitectureException(
                "Impossible de récupérer le personnage par son Id",
                "TODO",
                $exception
            );
        }
    }
}