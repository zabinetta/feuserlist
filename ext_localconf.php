<?php

use Taketool\Feuserlist\Controller\UserlistController;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'feuserlist',
            'feuserlist',
            [
                UserlistController::class => 'list'
            ],
            // non-cacheable actions
            [
                UserlistController::class => 'list'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    feuserlist {
                        iconIdentifier = feuserlist-plugin-feuserlist
                        title = LLL:EXT:feuserlist/Resources/Private/Language/locallang_db.xlf:tx_feuserlist_feuserlist.name
                        description = LLL:EXT:feuserlist/Resources/Private/Language/locallang_db.xlf:tx_feuserlist_feuserlist.description
                        tt_content_defValues {
                            CType = list
                            list_type = feuserlist_feuserlist
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'feuserlist-plugin-feuserlist',
				SvgIconProvider::class,
				['source' => 'EXT:feuserlist/Resources/Public/Icons/user_plugin_feuserlist.svg']
			);
		
    }
);
