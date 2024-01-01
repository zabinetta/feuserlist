<?php
namespace SebastianChristoph\ScFeuserlist\Controller;

/**
 * Class UserlistController
 *
 * * @package SebastianChristoph\ScFeuserlist\Controller
 */
class UserlistController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * FeRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $feRepository;

    /**
     * FeGroupRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $feGroupRepository;

    /**
     * list action
     *
     * @return void
     */
    public function listAction()
    {
        $pluginUsergroups = $this->settings['usergroups'];
        $pluginUserPIDs = $this->settings['userPIDs'];
        $pluginUserStatus = $this->settings['userStatus'];

        $now = time();

        $groupWhere = ($pluginUsergroups == '')
            ? ''
            :  "AND usergroup IN ($pluginUsergroups) \n";

        $queryStatement = trim("
            SELECT * FROM fe_users \n
            WHERE pid IN ($pluginUserPIDs)\n
            $groupWhere
            AND disable = 0 \n
            AND deleted = 0 \n
            AND (`starttime` = 0 OR `starttime` <= $now)
            AND (`endtime` = 0 OR `endtime` > $now)");

        $query = $this->feRepository->createQuery();
        $query->statement($queryStatement);

        $allUsers = $query->execute(TRUE);

        /*
        debug([
            '$pluginUsergroups' => $pluginUsergroups,
            '$pluginUserPIDs' => $pluginUserPIDs,
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
            $userDbgData[] = $user['uid'].':'.$user['username'].' s:'.$user['starttime'].' e:'.$user['endtime'];
        }

        $queryStatementGroup = 'SELECT uid,title FROM fe_groups WHERE hidden=0 AND hidden=0 AND deleted=0 ORDER BY title ASC';
        $query = $this->feRepository->createQuery();
        $query->statement($queryStatementGroup);
        $allGroups = $query->execute(TRUE);
        foreach ($allGroups as $g)
        {
            $allUsergroups[$g['uid']] = $g['title'];
        }

        $this->view->assignMultiple([
            'users' => $allUsersNew,
            'showUserStatus' => $pluginUserStatus,
            'allgroups' => $allUsergroups,
            'debug' =>$userDbgData,
            'query' => $queryStatement
        ]);
    }
}