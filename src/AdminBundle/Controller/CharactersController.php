<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Characters;
use AdminBundle\Enum\ActionEnum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CharactersController extends Controller
{
    /**
     * @Route("characters/", name="show_characters")
     * @return Response
     */
    public function showAction()
    {
        //Appel au service de dao
        $charactersDao = $this->get("noara.admin.dao.characters");
        //Appel à la méhtode du Dao
        $characters = $charactersDao->getAllCharacters();
        //Retourne la vue avec le personnage en paramètre
        return $this->render("AdminBundle:Characters:liste.html.twig", [
            "characters" => $characters,
        ]);
    }

    /**
     * @param Request $request
     * @Route("newCharacters/", name="admin_characters")
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        //Création de l'instance la race
        $character = new Characters();

        //appel de la méthode qui gère le formulaire
        return $this->managementForm(
            $request,
            $character,
            ActionEnum::ADD
        );

    }

    /**
     * @Route(
     *     "/editCharacters/{idCharacters}",
     *     requirements={"idCharacters": "\d+"},
     *     name="admin_characters_edit"
     * )
     * @param Request $request
     * @param int     $idCharacters
     * @return Response
     */
    public function editAction(Request $request, $idCharacters)
    {
        //Récupération du service de DAO
        $charactersDao = $this->get("noara.admin.dao.characters");

        //Recherche de la race avec son id pour modification
        $character = $charactersDao->getRaceById($idCharacters);

        //Retourne la méthode de gestion de formulaire
        return $this->managementForm(
            $request,
            $character,
            ActionEnum::EDIT
        );
    }

    /**
     * @Route(
     *     "/deleteCharacters/{idCharacters}",
     *     requirements={"idCharacters" : "\d+"},
     *     name="admin_characters_deleted"
     * )
     * @param int $idCharacters
     * @return RedirectResponse
     */
    public function deleteAction($idCharacters)
    {
        //Appel au service de persistance
        $charactersPersist = $this->get("noara.admin.persistance.characters");
        //Appel au service de DAO
        $charactersDao = $this->get("noara.admin.dao.characters");
        //Récupération de la race par son ID
        $characters = $charactersDao->getRaceById($idCharacters);
        //Methode de suppression
        $charactersPersist->deletedCharacters($characters);

        return $this->redirectToRoute("show_characters");
    }

    /**
     * @param Request      $request
     * @param Characters   $characters
     * @param              $action
     * @return Response
     */
    private function managementForm(
        Request $request,
        Characters $characters,
        $action
    ) {
        //appel du service qu gère le formulaire
        $formService = $this->get("noara.admin.form.characters");
        //Création du formulaire
        $form = $formService->newForm($characters, $action);
        //Récupération de la requete
        $form->handleRequest($request);

        //Vérification si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            //Appel au service de persistance
            $charactersPersistance = $this->get("noara.admin.persistance.characters");

            //Création de la redirection
            $redirection = null;

            //Si c'est un ajout
            if ($action === ActionEnum::ADD) {
                $characters = $formService->getCharactersForAdd($form, $characters);

                $redirection = $this->redirectToRoute("admin_characters");
            } else {
                $characters = $formService->getCharactersForEdit($form, $characters);

                $redirection = $this->redirectToRoute("show_characters");
            }

            //Appel du service de persistance pour sauvegarder la race
            $charactersPersistance->saveRace($characters);

            return $redirection;
        }

        $options = [
            "form" => $form->createView(),
            "characters" => $characters
        ];

        return $this->render("AdminBundle:Characters:form.html.twig", $options);
    }
}
