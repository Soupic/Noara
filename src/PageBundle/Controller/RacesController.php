<?php
/**
 * Created by PhpStorm.
 * User: picsou
 * Date: 10/08/17
 * Time: 15:29
 */

namespace PageBundle\Controller;


use PageBundle\Entity\Races;
use PageBundle\Enum\ActionEnum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RacesController extends Controller
{
    public function addAction(Request $request)
    {
        //Création de l'instance la race
        $race = new Races();
        //appel de la méthode qui gère le formulaire
        return $this->managementForm(
            $request,
            $race,
            ActionEnum::ADD
        );

    }

    private function managementForm(
        Request $request,
        Races $race,
        $action
    ) {
        //appel du service qu gère le formulaire
        $formService = $this->get("noara.page.form.post");
    }
}