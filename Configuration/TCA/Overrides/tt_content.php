<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'feuserlist',
    'feuserlist',
    'Frontend Userliste',
    'EXT:feuserlist/Resources/Public/Icons/user_plugin_feuserlist.svg'
);

/**
 * Remove unused fields
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['feuserlist_feuserlist'] = 'recursive,pages';

/**
 * Add Flexform for userlist plugin
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['feuserlist_feuserlist'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'feuserlist_feuserlist',
    'FILE:EXT:feuserlist/Configuration/FlexForm/list.xml'
);