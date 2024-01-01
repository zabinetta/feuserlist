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

        if ($pluginUsergroups == '') {
            $queryStatement = 'SELECT * FROM fe_users WHERE pid IN ('.$pluginUserPIDs.')';
        }
        else {
            $queryStatement = 'SELECT * FROM fe_users WHERE pid IN ('.$pluginUserPIDs.') AND usergroup IN ('.$pluginUsergroups.')';
        }

        $query = $this->feRepository->createQuery();
        $query->statement($queryStatement);
        $allUsers = $query->execute(TRUE);

        $time = time();

        foreach ($allUsers as $user) {
            if ((($time - $user['is_online']) < 600) && ($user['is_online'] > 0)) {
                $user['onlinestatus'] = 'online';
            }
            else {
                $user['onlinestatus'] = 'offline';
            }
            $allUsersNew[]=$user;
        }

        $this->view->assignMultiple([
            'users' => $allUsersNew,
            'showUserStatus' => $pluginUserStatus
        ]);
    }
}