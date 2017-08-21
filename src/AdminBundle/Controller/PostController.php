<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Post;
use AdminBundle\Enum\ActionEnum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    /**
     * @Route(
     *     "newPost/",
     *     name ="new_post"
     * )
     * @param Request $request
     * @return mixed
     */
    public function addAction(Request $request)
    {
        //Création de l'instance du post
        $post = new Post();

        //Appel au formulaire
        return $this->managementForm(
            $request,
            $post,
            ActionEnum::ADD
        );
    }

    /**
     * @Route(
     *     "editPost/{idPost}",
     *     requirements={"idPost": "\d+"},
     *     name="admin_post_edit"
     * )
     * @param Request $request
     * @param int     $idPost
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $idPost)
    {
        //Appel au service de DAO
        $postDao = $this->get("noara.admin.dao.post");
        //Récupération du post par son ID
        $post = $postDao->getPostById($idPost);
        //Retourne le formulaire remplis avec le post
        return $this->managementForm(
            $request,
            $post,
            ActionEnum::EDIT
        );
    }

    /**
     * @param Request $request
     * @param Post    $post
     * @param $action
     * @return null|RedirectResponse|Response
     */
    private function managementForm(
        Request $request,
        Post $post,
        $action
    ) {
        //Appel au service qui gère le formulaire
        $formService = $this->get("noara.admin.form.post");
        //Appel au formulaire l'ajout
        $form = $formService->newForm($post, $action);

        //Récupération de la requete
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Appel au service de persistance
            $postPersitance = $this->get("noara.admin.persistance.post");

            //Définition d'une variable de redirection
            $redirection = null;

            //Si c'est un ajout
            if ($action === ActionEnum::ADD) {
                $post = $formService->getPostForAdd($form, $post);

                //Affectation de la redirection
                $redirection = $this->redirectToRoute("new_post");
            } else {
                $post = $formService->getPostForEdit($form, $post);

                $redirection = $this->redirectToRoute("show_post");
            }

            //Appel à la méthode pour sauvegarder le post
            $postPersitance->savePost($post);

            return $redirection;
        }

        $options = [
            "form" => $form->createView(),
            "post" => $post
        ];

        return $this->render("AdminBundle:Post:form.html.twig", $options);
    }
}
