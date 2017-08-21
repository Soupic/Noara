<?php

namespace AdminBundle\Service\Form;


use AdminBundle\Entity\Post;
use AdminBundle\Enum\ActionEnum;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;

class PostForm
{
    const NAME_FORM = "Post";
    const KEY_TITLE = "Titre";
    const KEY_CONTENT = "Contenu";
    const KEY_ACTIVE = "Active";

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * PostForm constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function newForm(Post $post, $action)
    {
        $addPost = ActionEnum::ADD;
        $editPost = ActionEnum::EDIT;

        $form = $this->formFactory->createNamedBuilder(self::NAME_FORM, FormType::class, null, [
            "csrf_protection" => false,
        ]);

        if ($addPost) {
            $form = $this->;
        }
    }

    private function createFieldForNewForm(
        FormBuilderInterface $form,
        Post $post
    ) {
        $form->add(
            self::KEY_TITLE,
            TextType::class,
            $this->getOptionFieldTitle(
                $post,
                ActionEnum::ADD
            )
        );
    }

    /**
     * @param Post $post
     * @param      $action
     * @return array
     */
    private function getOptionFieldTitle(Post $post, $action)
    {
        //Création du champ option par défault
        $options = [
            "label" => "Titre",
            "attr" => [
                "placeholder" => "Saisir le titre de l'article ...",
            ],
            "empty_data" => null,
        ];
        //Vérifie si c'est une modofication
        if ($action === ActionEnum::EDIT) {
            $options["data"] = $post->getTitle();
        }

        return $options;
    }

    /**
     * @param Post $post
     * @param      $action
     * @return array
     */
    private function getOptionFieldContent(Post $post, $action)
    {
        $options = [
            "label" => "Contenu",
            "attr" => [
                "placeholder" => "Saisir le contenu de l'article ...",
            ],
            "empty_data" => null,
        ];

        if ($action === ActionEnum::EDIT) {
            $options["data"] = $post->getContent();
        }

        return $options;
    }

    /**
     * @param Post $post
     * @param      $action
     * @return array
     */
    private function getOptionFieldActive(Post $post, $action)
    {
        $options =[
            "label" => "Validez pour activé l'article",
            "required" => false
        ];
        //Vérifi si cet une modification
        if ($action === ActionEnum::EDIT) {
            //Récupère le nom de la race à modifier
            $options["data"] = $post->getActive();
        }

        return $options;
    }
}