<?php

defined('TYPO3') || die('Access denied.');

call_user_func(
    function () {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['beforeRendering']['form_frontend_validation'] = \R3H6\FormFrontendValidation\Hook\FormRenderableHook::class;
    }
);
