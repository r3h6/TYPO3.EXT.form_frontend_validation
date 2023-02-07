<?php

declare(strict_types=1);

namespace R3H6\FormFrontendValidation\Tests\Utility;

use Generator;
use R3H6\FormFrontendValidation\Utility\FormElementUtility;
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
 * FormElementUtilityTest
 */
class FormElementUtilityTest extends \Nimut\TestingFramework\TestCase\UnitTestCase
{
    /**
     * @test
     * @dataProvider getErrorMessageReturnsValidationErrorMessageProvider
     * @param string[]|null $arguments
     */
    public function getErrorMessageReturnsValidationErrorMessage(string $message, ?array $arguments, string $expected): void
    {
        $formElement = $this->createMock(FormElementInterface::class);
        $formElement->method('getProperties')->willReturn([
            'validationErrorMessages' => [
                ['code' => 123, 'message' => $message],
            ],
        ]);
        $errorMessage = FormElementUtility::getErrorMessage($formElement, 123, $arguments);
        self::assertSame($expected, $errorMessage);
    }

    /**
     * @return Generator<int, (string|null)[]|(string|string[])[], mixed, void>
     */
    public function getErrorMessageReturnsValidationErrorMessageProvider()
    {
        yield ['Foo %s bar', null, 'Foo %s bar'];
        yield ['Foo %s bar', ['bar'], 'Foo bar bar'];
    }
}
