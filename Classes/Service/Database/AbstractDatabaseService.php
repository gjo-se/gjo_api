<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Service\Database;

use GjoSe\GjoApi\Utility\EnvironmentUtility;
use GjoSe\GjoApi\Service\File\FileService;

abstract class AbstractDatabaseService
{
    protected const string BACKUP_FILE_PREFIX = 'dump_';

    protected const string BACKUP_FILE_EXTENSION = '.sql';

    protected const string DATE_FORMAT = 'Y-m-d--H-i-s';

    private const int DB_SOURCE = 1;

    private const int DB_TARGET = 3;

    private string $dbSource = '';

    private string $dbTarget = '';

    private string $backupFile = '';

    private array $connection = [];

    public function getConnections(): array
    {
        return $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'];
    }

    public function setConnection(): void
    {
        $connectionName = (EnvironmentUtility::getContextString() === $this->getDbSource()) ? 'Default' : $this->getDbSource();
        $this->connection = $this->getConnections()[$connectionName];
    }

    public function getConnection(): array
    {
        return $this->connection;
    }

    public function getDbUser(): string
    {
        return $this->getConnection()['user'];
    }

    public function getDbPassword(): string
    {
        return $this->getConnection()['password'];
    }

    public function getDbHost(): string
    {
        return $this->getConnection()['host'];
    }

    public function getDbName(): string
    {
        return $this->getConnection()['dbname'];
    }

    public function getDbSource(): string
    {
        return $this->dbSource;
    }

    public function setDbSource(string $dbSource): self
    {
        $this->dbSource = $dbSource;
        return $this;
    }

    public function getDbTarget(): string
    {
        return $this->dbTarget;
    }

    public function setDbTarget(string $dbTarget): self
    {
        $this->dbTarget = $dbTarget;
        return $this;
    }

    public function getBackupFile(): string
    {
        return $this->backupFile;
    }

    public function setBackupFile(string $backupFile): self
    {
        $this->backupFile = $backupFile;
        return $this;
    }

    public function getDbSourceByBackupFile(string $path): string
    {
        return explode('_', FileService::getFileBaseName($path))[self::DB_SOURCE];
    }

    public function getDbTargetByBackupFile(string $path): string
    {
        return explode('_', FileService::getFileBaseName($path))[self::DB_TARGET];
    }
}
