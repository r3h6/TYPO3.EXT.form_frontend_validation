<?php

namespace R3H6\FormFrontendValidation\Hook;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;
use Psr\EventDispatcher\EventDispatcherInterface;
use R3H6\FormFrontendValidation\Event\AppendFrontendValidationEvent;
use TYPO3\CMS\Form\Domain\Model\FormElements\FormElementInterface;
use TYPO3\CMS\Form\Domain\Model\Renderable\RootRenderableInterface;

class FormRenderableHook
{
    /**
     * @var \Psr\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function injectEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function beforeRendering(FormRuntime $formRuntime, RootRenderableInterface $renderable)
    {
        if ($renderable instanceof FormElementInterface) {
            foreach ($renderable->getValidators() as $validator) {
                $event = GeneralUtility::makeInstance(AppendFrontendValidationEvent::class, $validator, $renderable);
                $this->eventDispatcher->dispatch($event);
            }
        }
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
