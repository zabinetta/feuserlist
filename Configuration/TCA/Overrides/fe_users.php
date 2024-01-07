<?php

declare(strict_types=1);

$columnArray = [
    'usergroup' => [
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:fe_users.usergroup',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'fe_groups',
            'foreign_table_where' => '',// 'fe_groups.pid=###CURRENT_PID### ORDER BY fe_groups.title ASC',
            'size' => 6,
            'minitems' => 1,
            'maxitems' => 50,
            'itemsProcFunc' => \Taketool\Feuserlist\ItemsProcFunc\FilterItemsProcFunc::class . '->filterFeUser',
           ],
    ],
    'feuserlist_lockGroupsToThisPid' => [
        'label' => 'Nur Usergroups von dieser Seite',
        'onChange' => 'reload',
        'config' => [
            'renderType' => 'checkboxToggle',
            'type' => 'check',
        ],
        'exclude' => 1,
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $columnArray);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'feuserlist_lockGroupsToThisPid', '', 'after:password');