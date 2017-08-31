<?php

namespace AdminBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
* Class MediaFileType
* @package AdminBundle\Form\MediaFileType
*/
class MediaFileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
   {
       $builder
           ->add(
               "fichier", FileType::class
//               [
//                   "label" => $options['label'],
//                   "multiple" => $options["multiple"],
//               ]
           );
   }

    /**
     * @param OptionsResolver $resolver
     */
   public function configOptions(OptionsResolver $resolver)
   {
   		$resolver->setDefaults(array(
   			"data_class" => "AdminBundle\Entity\Media",
            "label" => "Ajouter un fichier",
            "multiple" => true,
   		));
   }
}