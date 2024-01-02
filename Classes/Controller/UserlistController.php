<?php
namespace SebastianChristoph\ScFeuserlist\Controller;

use SebastianChristoph\Domain\Repository\FrontendUserRepository;
use SebastianChristoph\Domain\Repository\FrontendUserGroupRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\DebugUtility;

/**
 * Class UserlistController
 *
 * * @package SebastianChristoph\ScFeuserlist\Controller
 */
class UserlistController extends ActionController
{

    /**
     * @var FrontendUserRepository
     */
    protected FrontendUserRepository $frontendUserRepository;

    /**
     * @var FrontendUserGroupRepository
     */
    protected FrontendUserGroupRepository $frontendUserGroupRepository;

    public function __construct(
        FrontendUserRepository $frontendUserRepository,
        FrontendUserGroupRepository $frontendUserGroupRepository,
    )
    {
        $this->frontendUserRepository = $frontendUserRepository;
        $this->frontendUserGroupRepository = $frontendUserGroupRepository;
    }


    /**
     * list action
     *
     * @return void
     */
    public function listAction()
    {
    /*
        SELECT * FROM fe_users \n
            WHERE pid IN ($pluginUserPIDs)\n
            $groupWhere
            AND disable = 0 \n
            AND deleted = 0 \n
            AND (`starttime` = 0 OR `starttime` <= $now)
            AND (`endtime` = 0 OR `endtime` > $now)");
    */
        $allUsers = $this->frontendUserRepository->findAllByPidAndGroups(
            $this->settings['userPIDs'],
            $this->settings['usergroups']
        );

        /*
        DebugUtility::debug([
            '$pluginUsergroups' => $this->settings['usergroups'],
            '$pluginUserPIDs' => $this->settings['userPIDs'],
            '$pluginUserStatus' => $pluginUserStatus,
            '$queryStatement' => $queryStatement,
            '$allUsers' => $allUsers,
        ], __line__.':listAction()');
        */

        $time = \time();
        foreach ($allUsers as $user) {
            if ((($time - $user['is_online']) < 600) && ($user['is_online'] > 0)) {
                $user['onlinestatus'] = 'online';
            }
            else {
                $user['onlinestatus'] = 'offline';
            }
            $allUsersNew[] = $user;
            //$userDbgData[] = $user['uid'].':'.$user['username'].' s:'.$user['starttime'].' e:'.$user['endtime'];
        }

        // 'SELECT uid,title FROM fe_groups WHERE hidden=0 AND deleted=0 ORDER BY title ASC';
        $allGroups = $this->frontendUserGroupRepository->findAll();
        DebugUtility::debug($allGroups);

        foreach ($allGroups as $g)
        {
            $allUsergroups[$g['uid']] = $g['title'];
        }

        $this->view->assignMultiple([
            'users' => $allUsersNew,
            'showUserStatus' => $this->settings['userStatus'],
            'allgroups' => $allUsergroups,
        ]);
    }
}