<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'SebastianChristoph.sc_feuserlist',
            'feuserlist',
            [
                'Userlist' => 'list'
            ],
            // non-cacheable actions
            [
                'Userlist' => 'list'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    feuserlist {
                        iconIdentifier = sc_feuserlist-plugin-feuserlist
                        title = LLL:EXT:sc_feuserlist/Resources/Private/Language/locallang_db.xlf:tx_sc_feuserlist_feuserlist.name
                        description = LLL:EXT:sc_feuserlist/Resources/Private/Language/locallang_db.xlf:tx_sc_feuserlist_feuserlist.description
                        tt_content_defValues {
                            CType = list
                            list_type = scfeuserlist_feuserlist
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'sc_feuserlist-plugin-feuserlist',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:sc_feuserlist/Resources/Public/Icons/user_plugin_feuserlist.svg']
			);
		
    }
);
