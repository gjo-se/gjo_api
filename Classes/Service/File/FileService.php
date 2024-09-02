<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Service\File;

use GjoSe\GjoApi\Utility\EnvironmentUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class FileService
{
    public function createFolderOnProjectPath(string $folder): bool
    {
        $path = EnvironmentUtility::getProjectPath() . '/' . $folder;

        if (!$this->fileOrFolderExists($path)) {
            GeneralUtility::mkdir_deep($path);
        }

        return $this->fileOrFolderExists($path);
    }

    // @todo-next-iteration:
    // More generic: see vendor/nng/nnhelpers/Classes/Utilities/File.php:324
    private function fileOrFolderExists(string $src): bool
    {
        return file_exists($src);
    }

    public static function getFileBaseName(string $path): string
    {
        return basename($path);
    }
}
