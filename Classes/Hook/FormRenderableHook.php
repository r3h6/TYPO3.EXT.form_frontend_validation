<?php

declare(strict_types=1);

namespace R3H6\FormFrontendValidation\Hook;

use R3H6\FormFrontendValidation\Validation\FrontendValidatorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Model\FormElements\FormElementInterface;
use TYPO3\CMS\Form\Domain\Model\Renderable\RootRenderableInterface;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;

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

final class FormRenderableHook
{
    /**
     * @var array<string, string>
     */
    protected static $availableFrontendValidators;

    public function beforeRendering(FormRuntime $formRuntime, RootRenderableInterface $renderable): void
    {
        if ($renderable instanceof FormElementInterface) {
            $availableFrontendValidators = $this->getAvailableFrontendValidators($formRuntime);
            foreach ($renderable->getValidators() as $validator) {
                $className = $availableFrontendValidators[get_class($validator)] ?? null;
                if ($className !== null) {
                    $frontendValidator = GeneralUtility::makeInstance($className);
                    if ($frontendValidator instanceof FrontendValidatorInterface) {
                        $frontendValidator($renderable, $validator);
                    }
                }
            }
            /** @var class-string<object>[] $frontendValidation */
            $frontendValidation = $renderable->getRenderingOptions()['frontendValidation'] ?? [];
            foreach ($frontendValidation as $className) {
                $frontendValidator = GeneralUtility::makeInstance($className);
                if ($frontendValidator instanceof FrontendValidatorInterface) {
                    $frontendValidator($renderable);
                }
            }
        }
    }

    /**
     * @phpstan-return array<string, class-string<object>>
     */
    protected function getAvailableFrontendValidators(FormRuntime $formRuntime): array
    {
        if (static::$availableFrontendValidators === null) {
            $validatorsDefinition = $formRuntime->getFormDefinition()->getValidatorsDefinition();
            $validators = [];
            foreach ($validatorsDefinition as $validatorDefinition) {
                if (isset($validatorDefinition['frontendValidation'])) {
                    foreach ((array)$validatorDefinition['frontendValidation'] as $className) {
                        $validators[(string)$validatorDefinition['implementationClassName']] = $className;
                    }
                }
            }
            static::$availableFrontendValidators = $validators;
        }
        return static::$availableFrontendValidators;
    }
}
