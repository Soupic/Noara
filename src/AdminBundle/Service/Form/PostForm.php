<?php

namespace AdminBundle\Service\Form;


use AdminBundle\Entity\Post;
use AdminBundle\Enum\ActionEnum;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class PostForm
{
    const NAME_FORM = "Article";
    const KEY_TITLE = "Titre";
    const KEY_CONTENT = "Contenu";
    const KEY_DATE = "Date";
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

    /**
     * @param Post $post
     * @param      $action
     * @return FormInterface
     */
    public function newForm(Post $post, $action)
    {
        $addPost = $action === ActionEnum::ADD;
        $editPost = $action === ActionEnum::EDIT;

        $form = $this->formFactory->createNamedBuilder(self::NAME_FORM, FormType::class, null, [
            "csrf_protection" => false,
        ]);

        if ($addPost) {
            $form = $this->createFieldForNewForm($form, $post);
        }

        if ($editPost) {
            $form = $this->createFieldForEditForm($form, $post);
        }

        return $form->getForm();
    }

    /**
     * @param FormBuilderInterface $form
     * @param Post                 $post
     * @return FormBuilderInterface
     */
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
        $form->add(
            self::KEY_CONTENT,
            TextareaType::class,
            $this->getOptionFieldContent(
                $post,
                ActionEnum::ADD
            )
        );
        $form->add(
            self::KEY_DATE,
            DateTimeType::class
        );
        $form->add(
            self::KEY_ACTIVE,
            CheckboxType::class,
            $this->getOptionFieldActive(
                $post,
                ActionEnum::ADD
            )
        );

        return $form;
    }

    /**
     * @param FormBuilderInterface $form
     * @param Post                 $post
     * @return FormBuilderInterface
     */
    public function createFieldForEditForm(
        FormBuilderInterface $form,
        Post $post
    ) {
        $form->add(
            self::KEY_TITLE,
            TextType::class,
            $this->getOptionFieldTitle(
                $post,
                ActionEnum::EDIT
            )
        );
        $form->add(
            self::KEY_CONTENT,
            TextareaType::class,
            $this->getOptionFieldContent(
                $post,
                ActionEnum::EDIT
            )
        );
        $form->add(
            self::KEY_DATE,
            DateTimeType::class
        );
        $form->add(
            self::KEY_ACTIVE,
            CheckboxType::class,
            $this->getOptionFieldActive(
                $post,
                ActionEnum::EDIT
            )
        );

        return $form;
    }

    /**
     * @param FormInterface $form
     * @param Post          $post
     * @return Post
     */
    public function getPostForAdd(
        FormInterface $form,
        Post $post
    ) {
        //Récupération des champ du formulaire
        $title = $this->getDataForm($form, self::KEY_TITLE);
        $content = $this->getDataForm($form, self::KEY_CONTENT);
        $date = $this->getDataForm($form, self::KEY_DATE);
        $active = $this->getDataForm($form, self::KEY_ACTIVE);

        $post->setTitle($title);
        $post->setContent($content);
        $post->setDate($date);
        $post->setActive($active);

        return $post;

    }

    /**
     * @param FormInterface $form
     * @param Post          $post
     * @return Post
     */
    public function getPostForEdit(
        FormInterface $form,
        Post $post
    ) {
        //Récupération des champ du formulaire
        $title = $this->getDataForm($form, self::KEY_TITLE);
        $content = $this->getDataForm($form, self::KEY_CONTENT);
        $date = $this->getDataForm($form, self::KEY_DATE);
        $active = $this->getDataForm($form, self::KEY_ACTIVE);

        $post->setTitle($title);
        $post->setContent($content);
        $post->setDate($date);
        $post->setActive($active);

        return $post;

    }

    /**
     * @param FormInterface $form
     * @param string        $key
     * @return mixed
     */
    private function getDataForm(FormInterface $form, $key)
    {
        //Récupération du champ du formulaire
        return $form[$key]->getData();
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