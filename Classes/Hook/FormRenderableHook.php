<?php

namespace R3H6\FormFrontendValidation\Hook;

use Psr\EventDispatcher\EventDispatcherInterface;
use R3H6\FormFrontendValidation\Event\AppendFrontendValidationEvent;
use R3H6\FormFrontendValidation\Validation\FrontendValidatorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Model\FormElements\FormElementInterface;
use TYPO3\CMS\Form\Domain\Model\Renderable\RootRenderableInterface;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;

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
                    $frontendValidator = GeneralUtility::makeInstance($availableFrontendValidators[$className]);
                    if ($frontendValidator instanceof FrontendValidatorInterface) {
                        $frontendValidator($renderable, $validator);
                    }
                }
            }
            $frontendValidation = $renderable->getRenderingOptions()['frontendValidation'] ?? [];
            foreach ($frontendValidation as $className) {
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

    // protected function enhanceWithValidation(FormElementInterface $formElement)
    // {
    //     foreach ($formElement->getValidators() as $validator) {
    //         $validatorClassName = get_class($validator);

    //         if (isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][self::EXTENSION_KEY]['frontendValidators'][$validatorClassName])) {
    //             $frontendValidators = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][self::EXTENSION_KEY]['frontendValidators'][$validatorClassName];
    //             ksort($frontendValidators, SORT_NUMERIC);
    //             foreach ($frontendValidators as $className) {
    //                 /* @var Frappant\FrpFormFrontendValidation\Validation\Frontend\FrontendValidator $validator */
    //                 $frontendValidator = GeneralUtility::makeInstance($className);
    //                 if ($frontendValidator instanceof FrontendValidator) {
    //                     $frontendValidator->enhance($formElement, $validator);
    //                     break;
    //                 }
    //             }
    //         }
    //     }
    // }
}
