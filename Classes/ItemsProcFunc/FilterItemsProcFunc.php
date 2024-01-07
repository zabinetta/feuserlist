<?php

namespace Taketool\Feuserlist\ItemsProcFunc;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FilterItemsProcFunc
{
    /**
     * @throws Exception
     * @throws DBALException
     */
    public function filterFeGroups(array &$params): void
    {
        $table = 'fe_groups';
        $isLockGroupsToThisPid = $params['row']['lockGroupsToThisPid'] === 1;
        $pidList = implode(',', array_column($params['row']['settings.userPIDs'],'uid'));
        $validPids = [];

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool
            ->getConnectionForTable($table)
            ->createQueryBuilder();

        $res = $queryBuilder
            ->select('*')
            ->from($table)
            ->where($queryBuilder->expr()->in('pid', $pidList))
            ->executeQuery();

        // get all valid group uid's
        while ($group = $res->fetchAssociative()) {
            $validPids[] = $group['uid'];
        }

        //remove every item, that is not in $rows['uid']
        foreach ($params['items'] as $key => $item) {
            if (!in_array($item[1], $validPids)) unset($params['items'][$key]);
        }
    }

    /**
     * @throws Exception
     * @throws DBALException
     */
    public function filterFeUser(array &$params): void
    {
        $table = 'fe_groups';
        if ($params['row']['feuserlist_lockGroupsToThisPid'] === 1)
        {
            $pid = $params['row']['pid'];
            $validPids = [];

            $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
            $queryBuilder = $connectionPool
                ->getConnectionForTable($table)
                ->createQueryBuilder();

            $res = $queryBuilder
                ->select('*')
                ->from($table)
                ->where($queryBuilder->expr()->eq('pid', $pid))
                ->executeQuery();

            // get all valid group uid's
            while ($group = $res->fetchAssociative()) {
                $validPids[] = $group['uid'];
            }

            //remove every item, that is not in $rows['uid']
            foreach ($params['items'] as $key => $item) {
                if (!in_array($item[1], $validPids)) unset($params['items'][$key]);
            }
        }

    }
}