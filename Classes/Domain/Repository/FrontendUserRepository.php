<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Taketool\Feuserlist\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;

/**
 * A Frontend User repository
 */
class FrontendUserRepository extends Repository {

    public function initializeObject()
    {
        /** @var QuerySettingsInterface $querySettings */
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @throws InvalidQueryException
     */
    public function findAllByPidAndGroups(string $userPidList, string $groupUidList): array
    {
       /*
        $queryStatement = trim("
             SELECT * FROM fe_users \n
             WHERE pid IN ($pluginUserPIDs)\n
             $groupWhere
             AND disable = 0;
       */

        $query = $this->createQuery();

        if ($groupUidList == '')
        {
            return $query
                ->matching(
                    $query->in('pid', explode(',',$userPidList)),
                )
                ->setOrderings(['company'=> QueryInterface::ORDER_ASCENDING])
                ->execute()
                ->toArray();
        } else {
            return $query
                ->matching(
                    $query->logicalAnd(
                        $query->in('pid', explode(',',$userPidList)),
                        $query->in('usergroup', explode(',',$groupUidList))
                    )
                )
                ->setOrderings(['company'=> QueryInterface::ORDER_ASCENDING])
                ->execute()
                ->toArray();
        }
    }

}
