<?php

namespace AdminBundle\Service\Form;

use AdminBundle\Entity\Characters;
use AdminBundle\Entity\Media;
use AdminBundle\Enum\ActionEnum;
use AdminBundle\Form\MediaFileType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CharactersForm
{
    const NAME_FORM = "Ajouter";
    const KEY_NAME = "Nom";
    const KEY_CONTENT = "Contenu";
    const KEY_ACTIVE = "Active";
    const KEY_FILES = "mediaFile";


    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param Characters $characters
     * @param $action
     * @return FormInterface
     */
    public function newForm(Characters $characters, $action)
    {
        // Récupération de la varaible action pour savoir si c'est un ajout ou une modification
        $addCharacters= $action === ActionEnum::ADD;
        $editCharacters = $action === ActionEnum::EDIT;

        //Création du formulaire
        $form = $this->formFactory->createNamedBuilder(self::NAME_FORM, FormType::class, null, [
            "csrf_protection" => false,
        ]);

        //Si c'est un ajout
        if ($addCharacters) {
            $form = $this->creationFieldForNewForm($form, $characters);
        }

        //Si c'est une modification
        if ($editCharacters) {
            //Création d'un formulaire avec les informations du personnage
            $form = $this->creationFieldForEditForm($form, $characters);
        }

        return $form->getForm();
    }

    /**
     * @param FormBuilderInterface $form
     * @param Characters           $characters
     * @return FormBuilderInterface
     */
    private function creationFieldForNewForm(
        FormBuilderInterface $form,
        Characters $characters
    ) {
        $form->add(
            self::KEY_NAME,
            TextType::class,
            $this->getOptionFieldName(
                $characters,
                ActionEnum::ADD
            )
        );

        $form->add(
            self::KEY_CONTENT,
            TextareaType::class,
            $this->getOptionFieldContent(
                $characters,
                ActionEnum::ADD
            )
        );

        $form->add(
            self::KEY_ACTIVE,
            CheckboxType::class,
            $this->getOptionFieldActive(
                $characters,
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
     * @param Characters           $characters
     * @return FormBuilderInterface
     */
    private function creationFieldForEditForm(
        FormBuilderInterface $form,
        Characters $characters
    ) {
        $form->add(
            self::KEY_NAME,
            TextType::class,
            $this->getOptionFieldName(
                $characters,
                ActionEnum::EDIT
            )
        );

        $form->add(
            self::KEY_CONTENT,
            TextareaType::class,
            $this->getOptionFieldContent(
                $characters,
                ActionEnum::EDIT
            )
        );

        $form->add(
            self::KEY_ACTIVE,
            CheckboxType::class,
            $this->getOptionFieldActive(
                $characters,
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
     * @param Characters    $characters
     * @return Characters
     */
    public function getCharactersForAdd(
        FormInterface $form,
        Characters $characters
    ) {

        /**
         * Permet d'instancier notre entité média pour l'upload des fichiers
         * @var Media
         */
        $media = new Media();

        $name = $this->getDataForm($form, self::KEY_NAME);
        $content = $this->getDataForm($form, self::KEY_CONTENT);
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
            $characters->setMedia($media);
        }

        $characters->setName($name);
        $characters->setContent($content);
        $characters->setActive($active);

        return $characters;
    }

    /**
     * @param FormInterface $form
     * @param Characters    $characters
     * @return Characters
     */
    public function getCharactersForEdit(
        FormInterface $form,
        Characters $characters
    ) {
        $name = $this->getDataForm($form, self::KEY_NAME);
        $content = $this->getDataForm($form, self::KEY_CONTENT);
        $active = $this->getDataForm($form, self::KEY_ACTIVE);

        $characters->setName($name);
        $characters->setContent($content);
        $characters->setActive($active);

        return $characters;
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
     * @param Characters $characters
     * @param            $action
     * @return array
     */
    private function getOptionFieldName(Characters $characters, $action)
    {
        //Création d'un champ option par défault
        $options = [
            "label" => "Name",
            "attr" => [
                "placeholder" => "Saisir le nom du personnage ...",
            ],
            "empty_data" => null,
        ];
        //Vérifi si cet une modification
        if ($action === ActionEnum::EDIT) {
            //Récupère le nom de la race à modifier
            $options["data"] = $characters->getName();
        }

        return $options;
    }

    /**
     * @param Characters $characters
     * @param            $action
     * @return array
     */
    private function getOptionFieldContent(Characters $characters, $action)
    {
        //Création d'un champ option par défault
        $options = [
            "label" => "Contenu",
            "attr" => [
                "placeholder" => "Saisir le descriptif du personnage ...",
            ],
            "empty_data" => null,
        ];
        //Vérifi si cet une modification
        if ($action === ActionEnum::EDIT) {
            //Récupère le nom de la race à modifier
            $options["data"] = $characters->getContent();
        }

        return $options;
    }

    /**
     * @param Characters $characters
     * @param            $action
     * @return array
     */
    private function getOptionFieldActive(Characters $characters, $action)
    {
        $options =[
            "label" => "Validez pour activé le personnage",
            "required" => false
        ];
        //Vérifi si cet une modification
        if ($action === ActionEnum::EDIT) {
            //Récupère le nom de la race à modifier
            $options["data"] = $characters->getActive();
        }

        return $options;
    }
}