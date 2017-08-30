<?php

namespace AdminBundle\Service\Form;


use AdminBundle\Entity\Characters;
use AdminBundle\Entity\Media;
use AdminBundle\Entity\Races;
use AdminBundle\Enum\ActionEnum;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use AdminBundle\Form\MediaFileType;

class RacesForm
{
    const NAME_FORM = "Ajouter";
    const KEY_NAME = "Nom";
    const KEY_CONTENT = "Contenu";
    const KEY_ACTIVE = "Active";
    const KEY_CHARACTERS = "Personnages";
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
     * @param Races $race
     * @param $action
     * @return FormInterface
     */
    public function newForm(Races $race, $action)
    {
        // Récupération de la varaible action pour savoir si c'est un ajout ou une modification
        $addRace = $action === ActionEnum::ADD;
        $editRace = $action === ActionEnum::EDIT;

        //Création du formulaire
        $form = $this->formFactory->createNamedBuilder(self::NAME_FORM, FormType::class, null, [
            "csrf_protection" => false,
        ]);

        //Si c'est un ajout
        if ($addRace) {
            $form = $this->creationFieldForNewForm($form, $race);
        }

        //Si c'est une modification
        if ($editRace) {
            //Création d'un formulaire avec les informations de la race
            $form = $this->creationFieldForEditForm($form, $race);
        }

        return $form->getForm();
    }

    /**
     * @param FormBuilderInterface $form
     * @param Races                $race
     * @return FormBuilderInterface
     */
    private function creationFieldForNewForm(
        FormBuilderInterface $form,
        Races $race
    ) {
        $form->add(
            self::KEY_NAME,
            TextType::class,
            $this->getOptionFieldName(
                $race,
                ActionEnum::ADD
            )
        );

        $form->add(
            self::KEY_CONTENT,
            TextareaType::class,
            $this->getOptionFieldContent(
                $race,
                ActionEnum::ADD
            )
        );

        $form->add(
            self::KEY_ACTIVE,
            CheckboxType::class,
            $this->getOptionFieldActive(
                $race,
                ActionEnum::ADD
            )
        );

        $form->add(
            self::KEY_CHARACTERS,
            EntityType::class,
            $this->getOptionFieldCharacters(
                $race,
                ActionEnum::ADD
            )
        );

        $form->add(
            self::KEY_FILES,
            CollectionType::class,
            $this->getOptionFieldFiles(
                $race,
                ActionEnum::ADD
            )
        );

        return $form;
    }

    /**
     * @param FormBuilderInterface $form
     * @param Races                $race
     * @return FormBuilderInterface
     */
    private function creationFieldForEditForm(
        FormBuilderInterface $form,
        Races $race
    ) {
        $form->add(
            self::KEY_NAME,
            TextType::class,
            $this->getOptionFieldName(
                $race,
                ActionEnum::EDIT
            )
        );

        $form->add(
            self::KEY_CONTENT,
            TextareaType::class,
            $this->getOptionFieldContent(
                $race,
                ActionEnum::EDIT
            )
        );

        $form->add(
            self::KEY_ACTIVE,
            CheckboxType::class,
            $this->getOptionFieldActive(
                $race,
                ActionEnum::EDIT
            )
        );

        $form->add(
            self::KEY_CHARACTERS,
            EntityType::class,
            $this->getOptionFieldCharacters(
                $race,
                ActionEnum::EDIT
            )
        );

        $form->add(
            self::KEY_FILES,
            MediaFileType::class
//            $this->getOptionFieldFiles(
//                $race,
//                ActionEnum::EDIT
//            )
        );

        return $form;
    }

    /**
     * @param FormInterface $form
     * @param Races         $race
     * @return Races
     */
    public function getRaceForAdd(
        FormInterface $form,
        Races $race
    ) {

        /**
         * @var Media
         */
        $media = new Media();

        $name = $this->getDataForm($form, self::KEY_NAME);
        $content = $this->getDataForm($form, self::KEY_CONTENT);
        $active = $this->getDataForm($form, self::KEY_ACTIVE);
        $character = $this->getDataForm($form, self::KEY_CHARACTERS);
        $mediaFile = $this->getDataForm($form, self::KEY_FILES);
        $file = $mediaFile["file"];


        if ($file !== null) {

            $media->setFile($file);
            $media->preUpload();
            $media->uniqName();
            $media->upload();
            $race->setMedia($media);
        }

        $race->setName($name);
        $race->setContent($content);
        $race->setActive($active);
        $race->setCharacters($character);

        return $race;
    }

    /**
     * @param FormInterface $form
     * @param Races         $race
     * @return Races
     */
    public function getRaceForEdit(
        FormInterface $form,
        Races $race
    ) {
        /**
         * @var Media
         */
        $media = new Media();

        $name = $this->getDataForm($form, self::KEY_NAME);
        $content = $this->getDataForm($form, self::KEY_CONTENT);
        $active = $this->getDataForm($form, self::KEY_ACTIVE);
        $character = $this->getDataForm($form, self::KEY_CHARACTERS);
        $mediaFile = $this->getDataForm($form, self::KEY_FILES);
        $file = $mediaFile["file"];


        if ($file !== null) {

            $media->setFile($file);
            $media->preUpload();
            $media->uniqName();
            $media->upload();
            $race->setMedia($media);
        }

        $race->setName($name);
        $race->setContent($content);
        $race->setActive($active);
        $race->setCharacters($character);

        return $race;
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
     * @param Races $race
     * @param       $action
     * @return array
     */
    private function getOptionFieldName(Races $race, $action)
    {
        //Création d'un champ option par défault
        $options = [
            "label" => "Name",
            "attr" => [
                "placeholder" => "Saisir le nom de la race ...",
            ],
            "empty_data" => null,
        ];
        //Vérifi si cet une modification
        if ($action === ActionEnum::EDIT) {
            //Récupère le nom de la race à modifier
            $options["data"] = $race->getName();
        }

        return $options;
    }

    /**
     * @param Races $race
     * @param       $action
     * @return array
     */
    private function getOptionFieldContent(Races $race, $action)
    {
        //Création d'un champ option par défault
        $options = [
            "label" => "Contenu",
            "attr" => [
                "placeholder" => "Saisir le descriptif de la race ...",
            ],
            "empty_data" => null,
        ];
        //Vérifi si cet une modification
        if ($action === ActionEnum::EDIT) {
            //Récupère le nom de la race à modifier
            $options["data"] = $race->getContent();
        }

        return $options;
    }

    /**
     * @param Races $race
     * @param       $action
     * @return array
     */
    private function getOptionFieldActive(Races $race, $action)
    {
        $options =[
            "label" => "Validez pour activé la race",
            "required" => false
        ];
        //Vérifi si cet une modification
        if ($action === ActionEnum::EDIT) {
            //Récupère le nom de la race à modifier
            $options["data"] = $race->getActive();
        }

        return $options;
    }

    /**
     * @param Races $race
     * @param       $action
     * @return array
     */
    private function getOptionFieldCharacters(Races $race, $action)
    {
        $options = [
            "label" => "Sélectionnez un personnage",
            "class" => Characters::class,
            "empty_data" => null,
            "query_builder" => function (EntityRepository $entityRepository) {
                $queryBuilder = $entityRepository->createQueryBuilder('char');
                $queryBuilder
                    ->addOrderBy("char.name", "ASC")
                ;
            },
        ];

        if ($action === ActionEnum::EDIT) {
            //Récupération du champ data du formulaire
            $options["data"] = $race->getCharacters();
        }

        return $options;
    }

    private function getOptionFieldFiles(Races $race, $action)
    {
        $options = [
            "entry_type" => MediaFileType::class,
        ];

        if ($action === ActionEnum::EDIT) {
            //Récupération du champ du formulaire
            $options["data"] = $race->getMedia();
        }

        return $options;
    }
}