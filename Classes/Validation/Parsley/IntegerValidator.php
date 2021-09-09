<?php

declare(strict_types=1);

namespace R3H6\FormFrontendValidation\Validation\Parsley;

use R3H6\FormFrontendValidation\Utility\FormElementUtility;
use R3H6\FormFrontendValidation\Validation\FrontendValidatorInterface;
use TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface;
use TYPO3\CMS\Form\Domain\Model\FormElements\FormElementInterface;

/***
 *
 * This file is part of the "Form Frontend Validation" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021
 *
 ***/

 /**
  * IntegerValidator
  */
class IntegerValidator implements FrontendValidatorInterface
{
    public function __invoke(FormElementInterface $formElement, ValidatorInterface $validator): void
    {
        FormElementUtility::addAttribute($formElement, 'data-parsley-trigger', 'change');
        FormElementUtility::addAttribute($formElement, 'data-parsley-errors-container', '#' . $formElement->getUniqueIdentifier() . '-errors');
        FormElementUtility::addAttribute($formElement, 'data-parsley-type', 'integer');
        FormElementUtility::addAttribute($formElement, 'data-parsley-type-message', FormElementUtility::getErrorMessage($formElement, 1221560494));
    }
}
