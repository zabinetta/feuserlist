<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'SC FrontendUserlist',
    'description' => 'Creates a userlist of frontendusers in the frontend with online status',
    'category' => 'plugin',
    'author' => 'Sebastian Christoph',
    'author_email' => 'admin@sebastian-christoph.de',
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
