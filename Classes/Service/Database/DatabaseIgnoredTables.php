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
        $ignoredTablesDevelopmentForDevelopment = [];
        return array_merge($ignoredTablesDevelopmentForDevelopment, self::getIgnoredTablesDefault());
    }

    /**
     * @return array<string>
     */
    public static function getIgnoredTablesDevelopmentForTesting(): array
    {
        $ignoredTablesDevelopmentForTesting = [];
        return array_merge($ignoredTablesDevelopmentForTesting, self::getIgnoredTablesDefault());
    }

    /**
     * TEST-DB is Master
     * @return array<string>
     */
    public static function getIgnoredTablesTestingForTesting(): array
    {
        $ignoredTablesTestingForTesting = [];
        return array_merge($ignoredTablesTestingForTesting, self::getIgnoredTablesDefault());
    }

    /**
     * not used on DEV
     * @return array<string>
     */
    public static function getIgnoredTablesTestingForDevelopment(): array
    {
        $ignoredTablesTestingForDevelopment = [
            'sys_history',
            'sys_log',
        ];

        return array_merge($ignoredTablesTestingForDevelopment, self::getIgnoredTablesDefault());
    }

    /**
     * on PROD: empty, get Data from TEST
     * @return array<string>
     */
    public static function getIgnoredTablesTestingForProduction(): array
    {
        $ignoredTablesTestingForProduction = [
            'fe_groups',
            'fe_users',
            'be_groups',
            'be_users',
            'tx_scheduler_task',
            'tx_scheduler_task_group',
            'sys_history',
            'sys_log',
        ];

        return array_merge($ignoredTablesTestingForProduction, self::getIgnoredTablesDefault());
    }

    /**
     * @return array<string>
     */
    public static function getIgnoredTablesProductionForProduction(): array
    {
        $ignoredTablesProductionForBackup = [];
        return array_merge($ignoredTablesProductionForBackup, self::getIgnoredTablesDefault());

    }

    /**
     * @return array<string>
     */
    public static function getIgnoredTablesProductionForDevelopment(): array
    {
        $ignoredTablesProductionForDevelopment = [];
        return array_merge($ignoredTablesProductionForDevelopment, self::getIgnoredTablesDefault());
    }
}
