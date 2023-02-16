<?php

declare(strict_types=1);

namespace R3H6\FormFrontendValidation\Utility;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
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
 * FormElementUtility
 */
class FormElementUtility
{
    /**
     * @param mixed $value
     */
    public static function addAttribute(FormElementInterface $formElement, string $name, $value): void
    {
        $properties = $formElement->getProperties();
        $fluidAdditionalAttributes = $properties['fluidAdditionalAttributes'] ?? [];
        $fluidAdditionalAttributes[$name] = $value;
        $formElement->setProperty('fluidAdditionalAttributes', $fluidAdditionalAttributes);
    }

    /**
     * @param array<mixed>|null $arguments
     */
    public static function getErrorMessage(FormElementInterface $formElement, int $code, ?array $arguments = null): string
    {
        $validationErrors = $formElement->getProperties()['validationErrorMessages'] ?? null;
        if (is_array($validationErrors)) {
            foreach ($validationErrors as $validationError) {
                if ((int)$validationError['code'] === $code) {
                    return is_array($arguments) ? vsprintf($validationError['message'], $arguments) : $validationError['message'];
                }
            }
        }
        return LocalizationUtility::translate('validation.error.' . $code, 'Form', $arguments);
    }
}
