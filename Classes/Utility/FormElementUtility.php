<?php

namespace R3H6\FormFrontendValidation\Utility;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
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
                    return vsprintf($validationError['message'], $arguments);
                }
            }
        }
        return LocalizationUtility::translate('validation.error.' . $code, 'Form', $arguments);
    }
}
