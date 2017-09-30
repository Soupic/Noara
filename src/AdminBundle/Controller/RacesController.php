<?php

namespace AdminBundle\Controller;


use AdminBundle\Entity\Races;
use AdminBundle\Enum\ActionEnum;
use AdminBundle\Service\Form\RacesForm;
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
    const KEY_ENABLE = 1;
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

        return $this->render("AdminBundle:Races:liste.html.twig", [
            "races" => $races,
        ]);

    }

    /**
     * @Route(
     *     "enableRace/{idRaces}",
     *     requirements={"idRaces": "\d+"},
     *      name = "admin_enable_races"
     * )
     * @param int $idRaces
     * @return RedirectResponse
     */
    public function enableAction($idRaces)
    {
        $activatorUtils = $this->get("noara.admin.utils.activator");

        $activatorUtils->enable(ActionEnum::KEY_RACE, $idRaces);

        return $this->redirectToRoute("show_races");
    }

    /**
     * @Route(
     *     "disabledRace/{idRaces}",
     *     requirements={"idRaces": "\d+"},
     *     name = "admin_disabled_races"
     * )
     * @param int $idRaces
     * @return RedirectResponse
     */
    public function disabledAction($idRaces)
    {
        $activatorUtils = $this->get("noara.admin.utils.activator");

        $activatorUtils->desabled(ActionEnum::KEY_RACE, $idRaces);

        return $this->redirectToRoute("show_races");
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
     * @Route(
     *     "/editRaces/{idRaces}",
     *     requirements={"idRaces": "\d+"},
     *     name="admin_races_edit"
     * )
     * @param Request $request
     * @param int     $idRaces
     * @return Response
     */
    public function editAction(Request $request, $idRaces)
    {
        //Récupération du service de DAO
        $raceDao = $this->get("noara.admin.dao.races");

        //Recherche de la race avec son id pour modification
        $race = $raceDao->getRaceById($idRaces);

        //Retourne la méthode de gestion de formulaire
        return $this->managementForm(
            $request,
            $race,
            ActionEnum::EDIT
        );
    }

    /**
     * @Route(
     *     "/deleteRaces/{idRaces}",
     *     requirements={"idRaces" : "\d+"},
     *     name="admin_races_deleted"
     * )
     * @param int $idRaces
     * @return RedirectResponse
     */
    public function deleteAction($idRaces)
    {
        //Appel au service de persistance
        $racesPersist = $this->get("noara.admin.persistance.races");
        //Appel au service de DAO
        $racesDao = $this->get("noara.admin.dao.races");
        //Récupération de la race par son ID
        $races = $racesDao->getRaceById($idRaces);
        //Methode de suppression
        $racesPersist->deletedRace($races);

        return $this->redirectToRoute("show_races");
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

                $redirection = $this->forward("AdminBundle:Races:show");
            } else {
                $race = $formService->getRaceForAdd($form, $race);

                $redirection = $this->redirectToRoute("show_races");
            }

            //Appel du service de persistance pour sauvegarder la race
            $racePersistance->saveRace($race);
//            dump("redirection");die();

            return $redirection;
        }

        $options = [
            "form" => $form->createView(),
            "race" => $race,
            "key_name" => RacesForm::KEY_NAME,
            "key_content" => RacesForm::KEY_CONTENT,
            "key_active" => RacesForm::KEY_ACTIVE,
            "key_characters" => RacesForm::KEY_CHARACTERS,
            "key_files" => RacesForm::KEY_FILES,
            "ajouter" => $action === ActionEnum::ADD,
            "modifier" => $action === ActionEnum::EDIT,
        ];

        if ($action === ActionEnum::ADD) {
            
            return $this->render("AdminBundle:Races:form.html.twig", $options);
        }
        return $this->render("AdminBundle:Races:edit.html.twig", $options);
    }
}