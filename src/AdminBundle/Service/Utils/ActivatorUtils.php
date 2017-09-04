<?php

namespace AdminBundle\Service\Utils;


use AdminBundle\Service\DAO\CharactersDao;
use AdminBundle\Service\DAO\PostDao;
use AdminBundle\Service\DAO\RacesDao;
use AdminBundle\Service\Persistance\CharactersPersistance;
use AdminBundle\Service\Persistance\PostPersistance;
use AdminBundle\Service\Persistance\RacesPersistance;

class ActivatorUtils
{
    const KEY_POST = "post";
    const KEY_RACE = "race";
    const KEY_CHAR = "characters";

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
        return $this->isValideForEnable();
    }

    private function isValideForEnable()
    {
        //On appel la méthode pour récupéré tout les post actif
        $postEnables = $this->postDao->getCountEnablePoste(1);
        //On vérifie dans la liste combien de poste sont à actif
        foreach ($postEnables as $enable) {
            dump($postEnables);die();
        }
//        dump($postEnable);die();
    }
}