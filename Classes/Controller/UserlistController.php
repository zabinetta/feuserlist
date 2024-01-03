<?php
namespace Taketool\Feuserlist\Controller;

use Taketool\Feuserlist\Domain\Repository\FrontendUserRepository;
use Taketool\Feuserlist\Domain\Repository\FrontendUserGroupRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;

/**
 * Class UserlistController
 *
 * * @package Taketool\Feuserlist\Controller
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
        FrontendUserGroupRepository $frontendUserGroupRepository
    )
    {
        $this->frontendUserRepository = $frontendUserRepository;
        $this->frontendUserGroupRepository = $frontendUserGroupRepository;
    }

    /**
     * list action
     *
     * @return void
     * @throws InvalidQueryException
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

        $time = \time();
        $userOnlineStatus = [];
        foreach ($allUsers as $user) {
            $userOnlineStatus[$user->getUid()] = (($time - $user->getIsOnline()) < 600) && ($user->getIsOnline() > 0);
        }

        // 'SELECT uid,title FROM fe_groups WHERE hidden=0 AND deleted=0 ORDER BY title ASC';
        $allGroups = $this->frontendUserGroupRepository->findAllSortByTitle($this->settings['userPIDs']);

        $allUsergroups = [];
        foreach ($allGroups as $g)
        {
            $allUsergroups[$g->getUid()] = $g->getTitle();
        }

        /*
        \nn\t3::debug([
            '$pluginUsergroups' => explode(',', $this->settings['usergroups']),
            '$pluginUserPIDs' => explode(',', $this->settings['userPIDs']),
            '$allUsers' => $allUsers,
            '$allGroups' => $allGroups,
        ], __line__.':listAction()');
        */

        $this->view->assignMultiple([
            'users' => $allUsers,
            'showUserStatus' => $this->settings['userStatus'],
            'userStatus' => $userOnlineStatus,
            'allgroups' => $allUsergroups,
        ]);
    }
}