<?php

declare(strict_types=1);

namespace R3H6\FormFrontendValidation\Hook;

use Psr\EventDispatcher\EventDispatcherInterface;
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

 /**
  * FormRenderableHook
  */
class FormRenderableHook
{
    /**
     * @var array<string, string>
     */
    protected static $availableFrontendValidators;

    /**
     * @var \Psr\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function injectEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function beforeRendering(FormRuntime $formRuntime, RootRenderableInterface $renderable): void
    {
        if ($renderable instanceof FormElementInterface) {
            $availableFrontendValidators = $this->getAvailableFrontendValidators($formRuntime);
            foreach ($renderable->getValidators() as $validator) {
                $className = get_class($validator);
                if (isset($availableFrontendValidators[$className])) {
                    // @phpstan-ignore-next-line because false interpretation in PHP 7.3
                    $frontendValidator = GeneralUtility::makeInstance($availableFrontendValidators[$className]);
                    if ($frontendValidator instanceof FrontendValidatorInterface) {
                        $frontendValidator($renderable, $validator);
                    }
                }
            }
            $frontendValidation = $renderable->getRenderingOptions()['frontendValidation'] ?? [];
            foreach ($frontendValidation as $className) {
                // @phpstan-ignore-next-line because false interpretation in PHP 7.3
                $frontendValidator = GeneralUtility::makeInstance($className);
                if (is_callable($frontendValidator)) {
                    $frontendValidator($renderable);
                }
            }
        }
    }

    /**
     * @return array<string, string>
     */
    protected function getAvailableFrontendValidators(FormRuntime $formRuntime): array
    {
        if (static::$availableFrontendValidators === null) {
            $validatorsDefinition = $formRuntime->getFormDefinition()->getValidatorsDefinition();
            $validators = [];
            foreach ($validatorsDefinition as $validatorDefinition) {
                if (isset($validatorDefinition['frontendValidation'])) {
                    foreach ((array)$validatorDefinition['frontendValidation'] as $className) {
                        $validators[(string)$validatorDefinition['implementationClassName']] = (string)$className;
                    }
                }
            }
            static::$availableFrontendValidators = $validators;
        }
        return static::$availableFrontendValidators;
    }
}
