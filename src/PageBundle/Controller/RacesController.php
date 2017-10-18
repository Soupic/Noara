<?php

namespace PageBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class RacesController
 * @package PageBundle\Controller
 */
class RacesController extends Controller
{
    const KEY_ENABLE = 1;

    /**
     * @Route("races/", name="show_races_json")
     * @return Response
     */
    public function showRaceEnableAction()
    {
        //Appel du DAO des races
        $raceDao = $this->get("noara.dao.races");
        //Utilisation de la méthode pour compté le nombre de races active
        $races = $raceDao->getEnableRace(self::KEY_ENABLE);
//        dump($races);die();

        //Envois des races récupéré à la vue pour traitement
        return $this->render("PageBundle:Races:liste.html.twig", [
            "races" => $races,
        ]);
    }
}