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

    /**
     * @param string $field
     * @param int    $idField
     */
    public function enable($field, $idField)
    {
        $post = $field === ActionEnum::KEY_POST;
        $race = $field === ActionEnum::KEY_RACE;
        $character = $field === ActionEnum::KEY_CHAR;
        //On vérifi si l'on peux passer l'élément à actif
        if ($this->isValideForEnable($field)) {
            if ($post) {
                //On récupère le post sur lequel nous avons cliqué
                //Doit appeler une méthode du DAO qui récupère le post
                $post = $this->postDao->getPostById($idField);
                //On lui passe alors actif de 0 à 1
                $post->setActive(1);
                //On persiste le post
                $this->postPersistance->savePost($post);
            } elseif ($race) {
                $race = $this->raceDao->getRaceById($idField);

                $race->setActive(1);

                $this->racePersistance->saveRace($race);
            } elseif ($character) {
                $character = $this->characterDao->getRaceById($idField);

                $character->setActive(1);

                $this->characterPersistance->saveCharacters($character);
            }
        }
    }

    /**
     * @param string $field
     * @param int    $idField
     */
    public function desabled($field, $idField)
    {
        $post = $field === ActionEnum::KEY_POST;
        $race = $field === ActionEnum::KEY_RACE;
        $character = $field === ActionEnum::KEY_CHAR;

        if ($post) {
            //On récupère le post sur lequel nous avons cliqué
            //Doit appeler une méthode du DAO qui récupère le post
            $post = $this->postDao->getPostById($idField);
            //On lui passe alors actif de 0 à 1
            $post->setActive(0);
            //On persiste le post
            $this->postPersistance->savePost($post);
        } elseif ($race) {
            $race = $this->raceDao->getRaceById($idField);

            $race->setActive(0);

            $this->racePersistance->saveRace($race);
        } elseif ($character) {
            $character = $this->characterDao->getRaceById($idField);

            $character->setActive(0);

            $this->characterPersistance->saveCharacters($character);
        }

    }

    /**
     * @param $field
     * @return bool
     */
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
            //On compte le nombre d'élement actif pour les post et les personnages
            $resultPostChar = count($countField);

        } elseif ($race) {
            //On appel la méthode pour récupéré tout les post actif
            $raceEnables = $this->raceDao->getCountEnableRace(self::KEY_ENABLE);
            $countFieldRace = $raceEnables;
            //Meme chose avec les races
            $resultRace = count($countFieldRace);


        } elseif ($character) {
            //On appel la méthode pour récupéré tout les post actif
            $charactertEnables = $this->characterDao->getCountEnableCharacter(self::KEY_ENABLE);
            $countField = $charactertEnables;
            //On compte le nombre d'élement actif pour les post et les personnages
            $resultPostChar = count($countField);

        }
//        //Si le tableau est inférieur à 5 éléments on passe le parametre actif à 1
//        if (($resultPostChar < 5) || $resultRace < 4) {
//            return true;
//        }
//
//        return false;

        if (isset($resultPostChar)) {
            if ($resultPostChar < 5) {
                return true;
            }
        }

        if (isset($resultRace)) {
            if ($resultRace < 4) {
                return true;
            }
        }

        return false;
    }
}