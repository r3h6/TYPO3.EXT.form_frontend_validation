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
 * StringLengthValidator
 */
class StringLengthValidator implements FrontendValidatorInterface
{
    public function __invoke(FormElementInterface $formElement, ValidatorInterface $validator): void
    {
        FormElementUtility::addAttribute($formElement, 'data-parsley-trigger', 'change');
        FormElementUtility::addAttribute($formElement, 'data-parsley-errors-container', '#' . $formElement->getUniqueIdentifier() . '-errors');

        $options = $validator->getOptions();

        if ($options['minimum'] && $options['maximum']) {
            FormElementUtility::addAttribute($formElement, 'data-parsley-length', sprintf('[%d, %d]', $options['minimum'], $options['maximum']));
            FormElementUtility::addAttribute($formElement, 'data-parsley-length-message', FormElementUtility::getErrorMessage($formElement, 1428504122, [$options['minimum'], $options['maximum']]));
        } elseif ($options['minimum']) {
            FormElementUtility::addAttribute($formElement, 'data-parsley-minlength', $options['minimum']);
            FormElementUtility::addAttribute($formElement, 'data-parsley-minlength-message', FormElementUtility::getErrorMessage($formElement, 1238108068, [$options['minimum']]));
        } elseif ($options['maximum']) {
            FormElementUtility::addAttribute($formElement, 'data-parsley-maxlength', $options['maximum']);
            FormElementUtility::addAttribute($formElement, 'data-parsley-maxlength-message', FormElementUtility::getErrorMessage($formElement, 1238108069, [$options['maximum']]));
        }
    }
}
