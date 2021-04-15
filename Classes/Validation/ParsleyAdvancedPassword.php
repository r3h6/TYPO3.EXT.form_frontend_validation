<?php

namespace R3H6\FormFrontendValidation\Validation;

use R3H6\FormFrontendValidation\Utility\FormElementUtility;
use TYPO3\CMS\Form\Domain\Model\FormElements\FormElementInterface;

/***
 *
 * This file is part of the "OAuth2 Server" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020
 *
 ***/

 /**
  * ParsleyAdvancedPassword
  */
class ParsleyAdvancedPassword
{
    public function __invoke(FormElementInterface $formElement): void
    {
        FormElementUtility::addAttribute($formElement, 'data-parsley-equalto', '#' . $formElement->getUniqueIdentifier() . '-confirmation');
        FormElementUtility::addAttribute($formElement, 'data-parsley-errors-container', '#' . $formElement->getUniqueIdentifier() . '-error-container');
        FormElementUtility::addAttribute($formElement, 'data-parsley-error-message', FormElementUtility::getErrorMessage($formElement, 1556283177));
    }
}
