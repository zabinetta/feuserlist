<?php
namespace Taketool\Feuserlist\Controller;

use Psr\Http\Message\ResponseInterface;
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
    public function listAction(): ResponseInterface
    {
        $allUsers = $this->frontendUserRepository->findAllByPidAndGroups(
            $this->settings['userPIDs'],
            $this->settings['usergroups']
        );

        $time = \time();
        $userOnlineStatus = [];
        foreach ($allUsers as $user) {
            $userOnlineStatus[$user->getUid()] = (($time - $user->getIsOnline()) < 600) && ($user->getIsOnline() > 0);
        }

        $allGroups = $this->frontendUserGroupRepository->findAllSortByTitle($this->settings['userPIDs']);

        $allUsergroups = [];
        foreach ($allGroups as $g)
        {
            $allUsergroups[$g->getUid()] = $g->getTitle();
        }


        $this->view->assignMultiple([
            'users' => $allUsers,
            'showUserStatus' => $this->settings['userStatus'],
            'userStatus' => $userOnlineStatus,
            'allgroups' => $allUsergroups,
        ]);

       return $this->responseFactory->createResponse()->withAddedHeader(
            'Content-Type', 'text/html; charset=utf-8'
            )->withBody(
            $this->streamFactory->createStream($this->view->render()
            )
        );
    }
}