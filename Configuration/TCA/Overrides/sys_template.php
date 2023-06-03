<?php

defined('TYPO3') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('form_frontend_validation', 'Configuration/TypoScript/Parsley', 'Form Validation "Parsley"');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('form_frontend_validation', 'Configuration/TypoScript/Parsley/JavaScript', 'Form Validation "Parsley JavaScript"');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('form_frontend_validation', 'Configuration/TypoScript/Parsley/Styles', 'Form Validation "Parsley Styles"');
