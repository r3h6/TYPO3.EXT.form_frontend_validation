<?php

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
  * NumberRangeValidator
  */
class NumberRangeValidator implements FrontendValidatorInterface
{
    public function __invoke(FormElementInterface $formElement, ValidatorInterface $validator): void
    {
        FormElementUtility::addAttribute($formElement, 'data-parsley-trigger', 'change');
        FormElementUtility::addAttribute($formElement, 'data-parsley-errors-container', '#' . $formElement->getUniqueIdentifier() . '-errors');

        $options = array_merge(['minimum' => 0, 'maximum' => 0], $validator->getOptions());

        if ($options['minimum'] > $options['maximum']) {
            $newMaximum = $options['minimum'];
            $options['minimum'] = $options['maximum'];
            $options['maximum'] = $newMaximum;
        }

        FormElementUtility::addAttribute($formElement, 'data-parsley-range', sprintf('[%d, %d]', $options['minimum'], $options['maximum']));
        FormElementUtility::addAttribute($formElement, 'data-parsley-range-message', FormElementUtility::getErrorMessage($formElement, 1221561046, [$options['minimum'], $options['maximum']]));
    }
}
