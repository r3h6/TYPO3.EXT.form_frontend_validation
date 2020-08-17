<?php

namespace R3H6\FormFrontendValidation\Event;

use TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface;
use TYPO3\CMS\Form\Domain\Model\FormElements\FormElementInterface;

final class AppendFrontendValidationEvent
{
    /** \TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface */
    private $validator;

    /** \TYPO3\CMS\Form\Domain\Model\FormElements\FormElementInterface */
    private $formElement;

    public function __construct(ValidatorInterface $validator, FormElementInterface $formElement)
    {
        $this->validator = $validator;
        $this->formElement = $formElement;
    }

    public function equalsValidator(string $className)
    {
        return $this->validator instanceof $className;
    }

    public function addAttribute(string $name, $value)
    {
        $properties = $this->formElement->getProperties();
        $fluidAdditionalAttributes = $properties['fluidAdditionalAttributes'] ?? [];
        $fluidAdditionalAttributes[$name] = $value;
        $this->formElement->setProperty('fluidAdditionalAttributes', $fluidAdditionalAttributes);
    }
}
