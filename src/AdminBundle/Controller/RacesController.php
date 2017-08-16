<?php

namespace AdminBundle\Controller;


use OC\Notification\Action;
use AdminBundle\Entity\Races;
use AdminBundle\Enum\ActionEnum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class RacesController
 * @package AdminBundle\Controller
 */
class RacesController extends Controller
{
    /**
     * @Route("races/", name="show_races")
     * @return Response
     */
    public function showAction()
    {
        //Appel au service de DAO
        $raceDao = $this->get("noara.admin.dao.races");
        //Appel la méthode d'affichage de la liste
        $races = $raceDao->getAllRaces();

        return $this->render("AdminBundle:", [
            "races" => $races,
        ]);

    }

    /**
     * @param Request $request
     * @Route("newRaces/", name="admin_races")
     * @return RedirectResponse|Response
     */
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

    /**
     * @param Request $request
     * @param Races   $race
     * @param         $action
     * @return Response
     */
    private function managementForm(
        Request $request,
        Races $race,
        $action
    ) {
        //appel du service qu gère le formulaire
        $formService = $this->get("noara.admin.form.races");

        //Création du formulaire
        $form = $formService->newForm($race, $action);
        //Récupération de la requete
        $form->handleRequest($request);

        //Vérification si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            //Appel au service de persistance
            $racePersistance = $this->get("noara.admin.persistance.races");

            //Création de la redirection
            $redirection = null;

            //Si c'est un ajout
            if ($action === ActionEnum::ADD) {
                $race = $formService->getRaceForAdd($form, $race);

                $redirection = $this->redirectToRoute("admin_races");
            }

            //Appel du service de persistance pour sauvegarder la race
            $racePersistance->saveRace($race);

            return $redirection;
        }

        $options = [
            "form" => $form->createView(),
            "race" => $race
        ];

        return $this->render("AdminBundle:Races:form.html.twig", $options);
    }
}