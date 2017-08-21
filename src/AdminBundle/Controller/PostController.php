<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
}
