<?php

namespace R3H6\FormFrontendValidation\EventListener;

use R3H6\FormFrontendValidation\Event\AppendFrontendValidationEvent;
use TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator;

class Html5Required
{
    public function __invoke(AppendFrontendValidationEvent $event)
    {
        if ($event->equalsValidator(NotEmptyValidator::class)) {
            $event->addAttribute('required', 'required');
        }
    }
}
