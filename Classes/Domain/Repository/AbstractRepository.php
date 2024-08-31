<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

abstract class AbstractRepository extends Repository
{
    private ?Typo3DbQueryParser $typo3DbQueryParser = null;

    public function injectTypo3DbQueryParser(Typo3DbQueryParser $typo3DbQueryParser): void
    {
        $this->typo3DbQueryParser = $typo3DbQueryParser;
    }

    /**
     * @template T
     * @param QueryInterface<T> $query
     */
    protected function debugSqlQuery(QueryInterface $query, bool $params = false): void
    {
        if ($this->typo3DbQueryParser instanceof Typo3DbQueryParser) {
            $queryBuilder = $this->typo3DbQueryParser->convertQueryToDoctrineQueryBuilder($query);
            DebuggerUtility::var_dump($queryBuilder->getSQL());
            if ($params) {
                DebuggerUtility::var_dump($queryBuilder->getParameters());
            }
        }
    }
}
