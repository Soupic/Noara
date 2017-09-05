<?php

namespace AdminBundle\Service\Utils;


use AdminBundle\Enum\ActionEnum;
use AdminBundle\Service\DAO\CharactersDao;
use AdminBundle\Service\DAO\PostDao;
use AdminBundle\Service\DAO\RacesDao;
use AdminBundle\Service\Persistance\CharactersPersistance;
use AdminBundle\Service\Persistance\PostPersistance;
use AdminBundle\Service\Persistance\RacesPersistance;

class ActivatorUtils
{
    const KEY_ENABLE = 1;

    /**
     * @var PostDao
     */
    private $postDao;

    /**
     * @var RacesDao
     */
    private $raceDao;

    /**
     * @var CharactersDao
     */
    private $characterDao;

    /**
     * @var PostPersistance
     */
    private $postPersistance;

    /**
     * @var RacesPersistance
     */
    private $racePersistance;

    /**
     * @var CharactersPersistance
     */
    private $characterPersistance;

    /**
     * ActivatorUtils constructor.
     * @param PostDao               $postDao
     * @param RacesDao              $raceDao
     * @param CharactersDao         $characterDao
     * @param PostPersistance       $postPersistance
     * @param RacesPersistance      $racePersistance
     * @param CharactersPersistance $characterPersistance
     */
    public function __construct(
        PostDao $postDao,
        RacesDao $raceDao,
        CharactersDao $characterDao,
        PostPersistance $postPersistance,
        RacesPersistance $racePersistance,
        CharactersPersistance $characterPersistance
    ) {
        $this->postDao = $postDao;
        $this->raceDao = $raceDao;
        $this->characterDao = $characterDao;
        $this->postPersistance = $postPersistance;
        $this->racePersistance = $racePersistance;
        $this->characterPersistance = $characterPersistance;
    }

    public function enable()
    {
        return $this->isValideForEnable(ActionEnum::KEY_POST);
    }

    private function isValideForEnable($field)
    {
        $post = $field === ActionEnum::KEY_POST;
        $race = $field === ActionEnum::KEY_RACE;
        $character = $field === ActionEnum::KEY_CHAR;
        //On vérifie si il s'agit d'un post, d'une race ou d'un personnage
        if ($post) {
            //On appel la méthode pour récupéré tout les post actif
            $postEnables = $this->postDao->getCountEnablePoste(self::KEY_ENABLE);
            $countField = $postEnables;

        } elseif ($race) {
            //On appel la méthode pour récupéré tout les post actif
            $raceEnables = $this->raceDao->getCountEnableRace(self::KEY_ENABLE);
            $countField = $raceEnables;

        } elseif ($character) {
            //On appel la méthode pour récupéré tout les post actif
            $charactertEnables = $this->characterDao->getCountEnableCharacter(self::KEY_ENABLE);
            $countField = $charactertEnables;

        }
        //On compte le nombre d'élement actif
        $result = count($countField);
        //Si le tableau est inférieur à 5 éléments on passe le parametre actif à 1
        if ($result < 5) {
            return true;
        }

        return false;
    }
}