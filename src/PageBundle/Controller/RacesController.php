<?php

namespace PageBundle\Controller;


use PageBundle\Entity\Races;
use PageBundle\Enum\ActionEnum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RacesController extends Controller
{
    /**
     * class PostController
     * @param Request $request
     * @Route("post/")
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
        $formService = $this->get("noara.page.form.post");
        //Création du formulaire
        $form = $formService->newForm($race, $action);
        //Récupération de la requete
        $form->handleRequest($request);

        $options = [
            "form" => $form->createView(),
            "race" => $race
        ];

        return $this->render("PageBundle:Post:post.html.twig", $options);
    }
}