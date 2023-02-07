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
 * DateRangeValidator
 */
class DateRangeValidator implements FrontendValidatorInterface
{
    public function __invoke(FormElementInterface $formElement, ValidatorInterface $validator): void
    {
        $options = $validator->getOptions();

        $dateFormat = $formElement->getProperties()['displayFormat'] ?? 'Y-m-d';
        $minDate = $options['minimum'] ? \DateTime::createFromFormat('Y-m-d', $options['minimum'])->format($dateFormat) : null; // @phpstan-ignore-line
        $maxDate = $options['maximum'] ? \DateTime::createFromFormat('Y-m-d', $options['maximum'])->format($dateFormat) : null; // @phpstan-ignore-line

        $minError = FormElementUtility::getErrorMessage($formElement, 1521293687, [$minDate]);
        $maxError = FormElementUtility::getErrorMessage($formElement, 1521293686, [$maxDate]);

        if ($minDate && $maxDate) {
            FormElementUtility::addAttribute($formElement, 'data-parsley-range', sprintf('[%s, %s]', $minDate, $maxDate));
            FormElementUtility::addAttribute($formElement, 'data-parsley-range-message', $minError . ' ' . $maxError);
        } elseif ($minDate) {
            FormElementUtility::addAttribute($formElement, 'data-parsley-min', $minDate);
            FormElementUtility::addAttribute($formElement, 'data-parsley-min-message', $minError);
            $formElement->setProperty('fluidAdditionalAttributes', ['max' => null]);
        } elseif ($maxDate) {
            FormElementUtility::addAttribute($formElement, 'data-parsley-max', $maxDate);
            FormElementUtility::addAttribute($formElement, 'data-parsley-max-message', $maxError);
            $formElement->setProperty('fluidAdditionalAttributes', ['min' => null]);
        }
        FormElementUtility::addAttribute($formElement, 'data-parsley-trigger', 'change');
        FormElementUtility::addAttribute($formElement, 'data-parsley-errors-container', '#' . $formElement->getUniqueIdentifier() . '-errors');
    }
}
