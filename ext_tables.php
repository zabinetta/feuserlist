<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'SebastianChristoph.sc_feuserlist',
            'feuserlist',
            'Frontend Userliste'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('sc_feuserlist', 'Configuration/TypoScript', 'SCFrontendUserlist');

    }
);
