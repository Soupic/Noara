<?php

namespace PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CharactersController extends Controller
{
    const KEY_ENABLE = 1;

    /**
     * @Route("characters/", name="show_characters_slider")
     * @return Response
     */
    public function showCharactersEnableAction()
    {
        $characterDao = $this->get("noara.dao.characters");

        $characters = $characterDao->getEnableCharacter(self::KEY_ENABLE);

        return $this->render("PageBundle:Characters:liste.html.twig", [
            "characters" => $characters,
        ]);
    }
}
