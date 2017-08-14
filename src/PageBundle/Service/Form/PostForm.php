<?php

namespace PageBundle\Service\Form;


use PageBundle\Entity\Races;
use PageBundle\Enum\ActionEnum;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class PostForm
{
    const NOM_FORM = "Races";
    const CLE_NAME = "Name";
    const KEY_CONTENT = "Contenu";
    const KEY_ACTIVE = "Active";

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
        $form = $this->formFactory->createNamedBuilder(self::NOM_FORM, FormType::class, null, [
            "csrf_protection" => false,
        ]);

        //Si c'est un ajout
        if($addRace) {
            $form = $this->creationFieldForNewForm($form, $race);
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
            self::CLE_NAME,
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

        return $form;
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
        if($action === ActionEnum::EDIT) {
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
        if($action === ActionEnum::EDIT) {
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
            "label" => "Validez pour activé l'article",
        ];
        //Vérifi si cet une modification
        if($action === ActionEnum::EDIT) {
            //Récupère le nom de la race à modifier
            $options["data"] = $race->getActive();
        }

        return $options;
    }
}