<?php

namespace PageBundle\Service\Form;


use Doctrine\DBAL\Types\TextType;
use PageBundle\Entity\Races;
use PageBundle\Enum\ActionEnum;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

class PostForm extends AbstractMasterForm
{
    const NOM_FORM = "Races";
    const CLE_NAME = "Name";

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
        $option = [
            "label" => "Name",
            "attr" => [
                "placeholder" => "Saisir le nom de la race ...",
            ],
            "empty_data" => null,
        ];
        //Vérifi si cet une modification
        if($action === ActionEnum::EDIT) {
            //Récupère le nom de la race à modifier
            $option["data"] = $race->getName();
        }

        return $option;
    }
}