<?php

namespace PageBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


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
        $raceDao = $this->get("noara.dao.races");
        $races = $raceDao->getCountEnableRace(self::KEY_ENABLE);
//        dump($races);die();

        foreach ($races as $race) {
            $test[] = $race;
        };

        dump($test);
        die();
//        $datas = [
//          "nom" => $races,
//        ];

        return new JsonResponse($test);
//        return $this->render("PageBundle:Races:liste.html.twig", [
//            "races" => $races,
//        ]);
    }
}