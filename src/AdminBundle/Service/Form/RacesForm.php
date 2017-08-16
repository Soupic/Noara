<?php

namespace AdminBundle\Service\Form;


use AdminBundle\Entity\Races;
use AdminBundle\Enum\ActionEnum;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class RacesForm
{
    const NOM_FORM = "Races";
    const KEY_NAME = "Nom";
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

        $name = $this->getDataForm($form, self::KEY_NAME);
        $content = $this->getDataForm($form, self::KEY_CONTENT);
        $active = $this->getDataForm($form, self::KEY_ACTIVE);

        $race->setName($name);
        $race->setContent($content);
        $race->setActive($active);

        return $race;
    }

    /**
     * @param FormInterface $form
     * @param               $key
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
            "required" => false
        ];
        //Vérifi si cet une modification
        if($action === ActionEnum::EDIT) {
            //Récupère le nom de la race à modifier
            $options["data"] = $race->getActive();
        }

        return $options;
    }
}