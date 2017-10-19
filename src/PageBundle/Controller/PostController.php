<?php

namespace PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostController
 * @package PageBundle\Controller
 */
class PostController extends Controller
{
    const KEY_ENABLE = 1;

    /**
     * @Route("post/", name="show_post_slider")
     * @return Response
     */
    public function showPostEnableAction()
    {
        $postDao = $this->get("noara.dao.posts");

        $posts = $postDao->getEnablePost(self::KEY_ENABLE);

        return $this->render("PageBundle:Posts:liste.html.twig", [
            "posts" => $posts,
        ]);
    }
}
