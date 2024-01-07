<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "feuserlist".
 *
 * Auto generated 08-09-2020 07:32
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Frontend Userlist',
  'description' => 'Creates a list of frontendusers and groups in the frontend. Fork from sc_feuserlist by Sebastion Christoph.",',
  'category' => 'plugin',
  'author' => 'Martin Keller',
  'author_email' => 'martin.keller@taketool.de',
  'state' => 'stable',
  'uploadfolder' => false,
  'createDirs' => '',
  'clearCacheOnLoad' => 0,
  'version' => '11.0.0',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '10.4.1-11.5.99',
        'vhs' => '6.0.0-7.9.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'clearcacheonload' => false,
  'author_company' => NULL,
);

