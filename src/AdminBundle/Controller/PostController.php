<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostController
 * @package AdminBundle\Controller
 */
class PostController extends Controller
{
    /**
     * @Route("posts/", name="show_posts")
     * @return Response
     */
    public function showAction()
    {
        $postDao = $this->get("noara.admin.dao.post");

        $posts = $postDao->getAllPost();

        return $this->render("AdminBundle:Post:liste.html.twig", [
            "posts" => $posts,
        ]);
    }

    public function addAction(Request $request)
    {
        //Création de l'instance du post
        $post = new Post();

        //Appel au formulaire
        return $this->;
    }

    private function managementForm(
        Request $request,
        Post $post,
        $action
    ) {
        //Appel au service qui gère le formulaire
        $form = $this->get("");
    }
}
