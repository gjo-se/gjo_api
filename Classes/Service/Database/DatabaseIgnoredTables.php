<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Service\Database;

abstract class DatabaseIgnoredTables
{
    /**
     * @return array<string>
     */
    public static function getIgnoredTablesDefault(): array
    {
        return [
            'be_sessions',
            'cache_hash',
            'cache_hash_tags',
            'cache_imagesizes',
            'cache_imagesizes_tags',
            'cache_news_category',
            'cache_news_category_tags',
            'cache_pages',
            'cache_pages_tags',
            'cache_rootline',
            'cache_rootline_tags',
            'cache_treelist',
            'cache_vhs_main',
            'cache_vhs_main_tags',
            'cache_vhs_markdown',
            'cache_vhs_markdown_tags',
            'fe_sessions',
            'tx_extensionmanager_domain_model_extension',
        ];
    }

    /**
     * @return array<string>
     */
    public static function getIgnoredTablesDevelopmentForDevelopment(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    public static function getIgnoredTablesDevelopmentForTesting(): array
    {
        return [];
    }

    /**
     * TEST-DB is Master
     * @return array<string>
     */
    public static function getIgnoredTablesTestingForTesting(): array
    {
        return [];
    }

    /**
     * not used on DEV
     * @return array<string>
     */
    public static function getIgnoredTablesTestingForDevelopment(): array
    {
        return [
            'sys_history',
            'sys_log',
        ];
    }

    /**
     * on PROD: empty, get Data from TEST
     * @return array<string>
     */
    public static function getIgnoredTablesTestingForProduction(): array
    {
        return [
            'fe_groups',
            'fe_users',
            'be_groups',
            'be_users',
            'tx_scheduler_task',
            'tx_scheduler_task_group',
            'sys_history',
            'sys_log',
        ];
    }

    /**
     * @return array<string>
     */
    public static function getIgnoredTablesProductionForProduction(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    public static function getIgnoredTablesProductionForDevelopment(): array
    {
        return [];
    }

    private static function getSourceTargetMergedWithDefaultMap(): array
    {
        return [
            'Development-Development' => array_merge(self::getIgnoredTablesDevelopmentForDevelopment(), self::getIgnoredTablesDefault()),
            'Development-Testing' => array_merge(self::getIgnoredTablesDevelopmentForTesting(), self::getIgnoredTablesDefault()),
            'Testing-Testing' => array_merge(self::getIgnoredTablesTestingForTesting(), self::getIgnoredTablesDefault()),
            'Testing-Development' => array_merge(self::getIgnoredTablesTestingForDevelopment(), self::getIgnoredTablesDefault()),
            'Testing-Production' => array_merge(self::getIgnoredTablesTestingForProduction(), self::getIgnoredTablesDefault()),
            'Production-Production' => array_merge(self::getIgnoredTablesProductionForProduction(), self::getIgnoredTablesDefault()),
            'Production-Development' => array_merge(self::getIgnoredTablesProductionForDevelopment(), self::getIgnoredTablesDefault()),
        ];
    }

    public static function getIgnoredMergedTables(string $dbSource, string $dbTarget): array
    {
        $sourceTargetMergedWithDefaultMap = self::getSourceTargetMergedWithDefaultMap();
        $key = $dbSource . '-' . $dbTarget;
        return $sourceTargetMergedWithDefaultMap[$key] ?? [];
    }
}
