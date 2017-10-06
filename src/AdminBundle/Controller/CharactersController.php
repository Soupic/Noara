<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Characters;
use AdminBundle\Enum\ActionEnum;
use AdminBundle\Service\Form\CharactersForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CharactersController extends Controller
{
    /**
     * @Route("characters/", name="show_characters")
     * @param Request $request
     * @return Response
     */
    public function showAction(Request $request)
    {
        //Appel au service de dao
        $charactersDao = $this->get("noara.admin.dao.characters");
        //Appel à la méhtode du DAO
        $characters = $charactersDao->getAllCharacters();
        
        $character = new Characters();
        
        $action = 1;
        
        //appel du service qu gère le formulaire
        $formService = $this->get("noara.admin.form.characters");
        //Création du formulaire
        $form = $formService->newForm($character, $action);
        //Récupération de la requete
        $form->handleRequest($request);

        //Vérification si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            //Appel au service de persistance
            $charactersPersistance = $this->get("noara.admin.persistance.characters");

            $character = $formService->getCharactersForAdd($form, $character);

            //Appel du service de persistance pour sauvegarder la race
            $charactersPersistance->saveCharacters($character);

            return $this->redirectToRoute("show_characters");
        }
        
        //Retourne la vue avec le personnage en paramètre
        return $this->render("AdminBundle:Characters:liste.html.twig", [
            "characters" => $characters,
            "form" => $form->createView(),
            "character" => $character,
            "key_name" => CharactersForm::KEY_NAME,
            "key_content" => CharactersForm::KEY_CONTENT,
            "key_active" => CharactersForm::KEY_ACTIVE,
            "key_files" => CharactersForm::KEY_FILES,
            "ajouter" => $action === ActionEnum::ADD,
        ]);
    }

    /**
     * @Route(
     *     "enableChar/{idCharacter}",
     *     requirements={"idCharacter": "\d+"},
     *      name = "admin_enable_characters"
     * )
     * @param int $idCharacter
     * @return RedirectResponse
     */
    public function enableAction($idCharacter)
    {
        $activatorUtils = $this->get("noara.admin.utils.activator");

        $activatorUtils->enable(ActionEnum::KEY_CHAR, $idCharacter);

        return $this->redirectToRoute("show_characters");
    }

    /**
     * @Route(
     *     "disabledChar/{idCharacter}",
     *     requirements={"idCharacter": "\d+"},
     *     name = "admin_disabled_characters"
     * )
     * @param int $idCharacter
     * @return RedirectResponse
     */
    public function disabledAction($idCharacter)
    {
        $activatorUtils = $this->get("noara.admin.utils.activator");

        $activatorUtils->desabled(ActionEnum::KEY_CHAR, $idCharacter);

        return $this->redirectToRoute("show_characters");
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

                $characters = $formService->getCharactersForAdd($form, $characters);

            //Appel du service de persistance pour sauvegarder la race
            $charactersPersistance->saveCharacters($characters);
            
            return $this->redirectToRoute("show_characters");
        }

        $options = [
            "form" => $form->createView(),
            "characters" => $characters,
            "key_name" => CharactersForm::KEY_NAME,
            "key_content" => CharactersForm::KEY_CONTENT,
            "key_active" => CharactersForm::KEY_ACTIVE,
            "key_files" => CharactersForm::KEY_FILES,
            "ajouter" => $action === ActionEnum::ADD,
            "modifier" => $action === ActionEnum::EDIT,
        ];

        return $this->render("AdminBundle:Characters:edit.html.twig", $options);
    }
}
