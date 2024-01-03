<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        ExtensionUtility::registerPlugin(
            'feuserlist',
            'feuserlist',
            'Frontend Userliste'
        );

        ExtensionManagementUtility::addStaticFile('feuserlist', 'Configuration/TypoScript', 'SCFrontendUserlist');

    }
);
