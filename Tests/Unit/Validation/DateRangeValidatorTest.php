<?php

declare(strict_types=1);

namespace R3H6\FormFrontendValidation\Tests\Validation\Parsley;

use Nimut\TestingFramework\TestCase\UnitTestCase;
use R3H6\FormFrontendValidation\Validation\Parsley\DateRangeValidator;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LocalizationFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Model\FormElements\FormElementInterface;
use TYPO3\CMS\Form\Mvc\Validation\DateRangeValidator as ValidationDateRangeValidator;

class DateRangeValidatorTest extends UnitTestCase
{
    protected function setUp(): void
    {
        // $GLOBALS['LANG'] = $this->createMock(LanguageService::class);

        // $factory = $this->createMock(LocalizationFactory::class);
        // $factory->method('getParsedData')->willReturn([]);
        // GeneralUtility::setSingletonInstance(LocalizationFactory::class, $factory);
    }

    /**
     * @test
     */
    public function foo()
    {
        self::markTestIncomplete();
        // $formElement = $this->createMock(FormElementInterface::class);
        // $validator = new ValidationDateRangeValidator([
        //     'minimum' => '2021-09-30'
        // ]);

        // $subject = new DateRangeValidator();
        // $subject($formElement, $validator);
    }
}
