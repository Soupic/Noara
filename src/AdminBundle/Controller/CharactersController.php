<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

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
}
