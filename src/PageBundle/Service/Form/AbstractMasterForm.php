<?php

namespace PageBundle\Service\Form;


use Symfony\Component\Form\FormFactoryInterface;

class AbstractMasterForm
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var Router
     */
    protected $router;

    /**
     * AbstractMasterForm constructor.
     * @param FormFactoryInterface $formFactory
     * @param Router               $router
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Router $router
    ) {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }
}