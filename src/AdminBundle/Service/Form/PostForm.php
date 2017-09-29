<?php

namespace AdminBundle\Service\Form;


use AdminBundle\Entity\Media;
use AdminBundle\Entity\Post;
use AdminBundle\Enum\ActionEnum;
use AdminBundle\Form\MediaFileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class PostForm
{
    const NAME_FORM = "Ajouter";
    const KEY_TITLE = "Titre";
    const KEY_CONTENT = "Contenu";
    const KEY_DATE = "Date";
    const KEY_ACTIVE = "Active";
    const KEY_FILES = "mediaFile";


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
//        $form->add(
//            self::KEY_DATE,
//            DateTimeType::class
//        );
        $form->add(
            self::KEY_ACTIVE,
            CheckboxType::class,
            $this->getOptionFieldActive(
                $post,
                ActionEnum::ADD
            )
        );

        $form->add(
            self::KEY_FILES,
            MediaFileType::class
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

        $form->add(
            self::KEY_FILES,
            MediaFileType::class
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

        /**
         * Permet d'instancier notre entité média pour l'upload des fichiers
         * @var Media
         */
        $media = new Media();

        //Récupération des champ du formulaire
        $title = $this->getDataForm($form, self::KEY_TITLE);
        $content = $this->getDataForm($form, self::KEY_CONTENT);
//        $date = $this->getDataForm($form, self::KEY_DATE);
        $date = new \DateTime();
        $active = $this->getDataForm($form, self::KEY_ACTIVE);
        //Attention MediaFile contient un tableau associatif
        $mediaFile = $this->getDataForm($form, self::KEY_FILES);
        // Si un fichier est présent
        if ($mediaFile["fichier"] !== null) {
            //On récupère notre fichier
            $file = $mediaFile["fichier"];
            //Methode d'upload du fichier
            $media->setFile($file);
            $media->preUpload();
            //on lui attribut un nom unique
            $media->uniqName();
            $media->upload();
            $post->setMedia($media);
        }

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