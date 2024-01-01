<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sc_feuserlist',
    'feuserlist',
    'Frontend Userliste',
    'EXT:sc_feuserlist/Resources/Public/Icons/user_plugin_feuserlist.svg'
);

/**
 * Remove unused fields
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['scfeuserlist_feuserlist'] = 'recursive,pages';

/**
 * Add Flexform for userlist plugin
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['scfeuserlist_feuserlist'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'scfeuserlist_feuserlist',
    'FILE:EXT:sc_feuserlist/Configuration/FlexForm/list.xml'
);