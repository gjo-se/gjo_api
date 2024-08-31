<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Service\Site;

use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class SiteSettingsService extends AbstractSiteService
{
    public function getSiteSettings(): array
    {
        $site = $this->getSite();
        return $site instanceof Site ? ($site->getConfiguration()['settings'] ?? []) : [];
    }

    public function getBackupPath(): string
    {
        return $this->getSiteSettings()['gjoconsole']['backupPath'] ?? '';
    }

    /** @return array<string> */
    public function getBackupTargets(): array
    {
        return $this->getSiteSettings()['gjoconsole']['backupTargets'] ?? [];
    }

    /** @return array<string> */
    public function getTemplateRootPaths(): array
    {
        $site = $this->getSite();
        return $site instanceof Site ? ($site->getConfiguration()['settings']['gjoproducts']['view']['templateRootPaths'] ?? []) : [];
    }

    public function getTemplateRootPath(int $index = 0): string
    {
        $templateRootPath = $this->getTemplateRootPaths()[$index] ?? '';
        return GeneralUtility::getFileAbsFileName($templateRootPath);
    }

    /** @return array<string> */
    public function getPartialRootPaths(): array
    {
        $site = $this->getSite();
        return $site instanceof Site ? ($site->getConfiguration()['settings']['gjositepackage']['view']['partialRootPaths'] ?? []) : [];
    }

    public function getPartialRootPath(int $index = 0): string
    {
        $partialRootPath = $this->getPartialRootPaths()[$index] ?? '';
        return GeneralUtility::getFileAbsFileName($partialRootPath);
    }
}
