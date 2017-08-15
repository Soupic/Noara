<?php

namespace PageBundle\Controller;


use OC\Notification\Action;
use PageBundle\Entity\Races;
use PageBundle\Enum\ActionEnum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RacesController extends Controller
{
    /**
     * class PostController
     * @param Request $request
     * @Route("races/", name="races")
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
        $formService = $this->get("noara.page.form.races");

        //Création du formulaire
        $form = $formService->newForm($race, $action);
        //Récupération de la requete
        $form->handleRequest($request);

        //Vérification si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            //Appel au service de persistance
            $racePersistance = $this->get("noara.page.persistance.races");

            //Création de la redirection
            $redirection = null;

            //Si c'est un ajout
            if ($action === ActionEnum::ADD) {
                $race = $formService->getRaceForAdd($form, $race);

//                $redirection = $this->redirectToRoute("races/");
            }

            $racePersistance->saveRace($race);

            return $redirection;
        }

        $options = [
            "form" => $form->createView(),
            "race" => $race
        ];

        return $this->render("PageBundle:Races:form.html.twig", $options);
    }
}