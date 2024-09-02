<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Service\Database;

use TYPO3\CMS\Core\SingletonInterface;

final class RestoreDatabaseService extends AbstractDatabaseService implements SingletonInterface
{
    public function restore(): bool
    {
        $this->setConnection();
        shell_exec($this->getCmd());

        return true;
    }

    private function getCmd(): string
    {
        $cmdParts = [
            'mysql',
            '-u' . $this->getDbUser(),
            '-p' . $this->getDbPassword(),
            '-h' . $this->getDbHost(),
            $this->getDbName(),
            ' < ' . $this->getBackupFile(),
        ];

        return implode(' ', $cmdParts);
    }
}
