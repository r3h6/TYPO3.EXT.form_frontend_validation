<?php

namespace R3H6\FormFrontendValidation\Validation;

use R3H6\FormFrontendValidation\Utility\FormElementUtility;
use TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface;
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
  * ParsleyDateRangeValidator
  */
class ParsleyDateRangeValidator implements FrontendValidatorInterface
{
    public function __invoke(FormElementInterface $formElement, ValidatorInterface $validator): void
    {
        $options = $validator->getOptions();

        $minError = FormElementUtility::getErrorMessage($formElement, 1521293687, [$options['minimum']]);
        $maxError = FormElementUtility::getErrorMessage($formElement, 1521293686, [$options['maximum']]);

        if ($options['minimum'] && $options['maximum']) {
            FormElementUtility::addAttribute($formElement, 'data-parsley-range', sprintf('[%s, %s]', $options['minimum'], $options['maximum']));
            FormElementUtility::addAttribute($formElement, 'data-parsley-error-message', $minError . ' ' . $maxError);
        } elseif ($options['minimum']) {
            FormElementUtility::addAttribute($formElement, 'data-parsley-min', $options['minimum']);
            FormElementUtility::addAttribute($formElement, 'data-parsley-error-message', $minError);
        } elseif ($options['maximum']) {
            FormElementUtility::addAttribute($formElement, 'data-parsley-max', $options['maximum']);
            FormElementUtility::addAttribute($formElement, 'data-parsley-error-message', $maxError);
        }

        FormElementUtility::addAttribute($formElement, 'data-parsley-trigger', 'change');
        FormElementUtility::addAttribute($formElement, 'data-parsley-errors-container', '#' . $formElement->getUniqueIdentifier() . '-error-container');
    }
}
