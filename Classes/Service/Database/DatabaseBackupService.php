<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Service\Database;

use GjoSe\GjoApi\Service\File\FileService;
use GjoSe\GjoApi\Service\Site\SiteSettingsService;
use GjoSe\GjoApi\Utility\EnvironmentUtility;
use TYPO3\CMS\Core\Core\ApplicationContext;
use TYPO3\CMS\Core\SingletonInterface;

final class DatabaseBackupService extends AbstractDatabaseService implements SingletonInterface
{
    private const string DUMP_PARAMS_COMPLETE = '--opt --single-transaction';

    public function __construct(
        private readonly SiteSettingsService $siteSettingsService,
        private readonly FileService $fileService
    ) {}

    public function backup(): bool
    {
        $this->setConnection();
        $this->fileService->createFolderOnProjectPath($this->getBackupPathName());
        shell_exec($this->getCmd());

        return true;
    }

    private function getCmd(): string
    {
        $cmdParts = [
            'mysqldump',
            '-u' . $this->getDbUser(),
            '-p' . $this->getDbPassword(),
            '-h' . $this->getDbHost(),
            $this->getDbName(),
            self::DUMP_PARAMS_COMPLETE,
            $this->getIgnoredMergedTablesString(),
            '> ' . EnvironmentUtility::getProjectPath() . '/' . $this->getBackupPathName() . '/' . $this->getBackupFileName(),
        ];

        return implode(' ', $cmdParts);
    }

    public function convertDefaultConnectionNameToContext(string $connectionName): string|ApplicationContext
    {
        return $connectionName === 'Default' ? EnvironmentUtility::getContext() : $connectionName;
    }

    private function getBackupPathName(): string
    {
        return $this->siteSettingsService->getBackupPath() . '/' . $this->getDbSourceAndDbTargetName();
    }

    private function getDbSourceAndDbTargetName(): string
    {
        return $this->getDbSource() . '_for_' . $this->getDbTarget();
    }

    private function getBackupFileName(): string
    {
        return parent::BACKUP_FILE_PREFIX . $this->getDbSourceAndDbTargetName() . '_' . $this->getBackupDateTime() . parent::BACKUP_FILE_EXTENSION;
    }

    private function getBackupDateTime(): string
    {
        return date(parent::DATE_FORMAT);
    }

    private function getIgnoredMergedTablesString(): string
    {
        $ignoredTablesArr = array_map(function (string $ignoredTable): string {
            return '--ignore-table=' . $this->getDbName() . '.' . $ignoredTable;
        }, DatabaseIgnoredTables::getIgnoredMergedTables($this->getDbSource(), $this->getDbTarget()));

        return implode(' ', $ignoredTablesArr);
    }
}
