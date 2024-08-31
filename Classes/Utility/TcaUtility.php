<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Utility;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

final class TcaUtility
{
    public static function setTcaCtype(string $ext, string $contentElement, string $table = 'tt_content'): void
    {
        $extSignature = str_replace('_', '', $ext);
        $cType = $extSignature . '_ce_' . $contentElement;

        $tca = [
            'types' => [
                $cType => [
                    'showitem' => '
                    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                        --palette--;;general,
                        header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header.ALT.html_formlabel,
                    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                        --palette--;;frames, --palette--;;appearanceLinks,
                    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, --palette--;;language,
                    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, --palette--;;hidden,
                        --palette--;;access, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                        categories, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                        rowDescription, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
                ',
                ],
            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);

        $flexForm = ExtensionManagementUtility::extPath($ext) . 'Configuration/FlexForms/' . $cType . '.xml';
        if (file_exists($flexForm)) {
            ExtensionManagementUtility::addPiFlexFormValue(
                '*',
                'FILE:EXT:' . $ext . '/Configuration/FlexForms/' . $cType . '.xml',
                $cType
            );

            $newFieldsString = 'pi_flexform;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:flexform_formlabel';
            ExtensionManagementUtility::addToAllTCAtypes($table, $newFieldsString, $cType, 'after:header');
        }

    }

    /** @return array<string, mixed> */
    public static function getDefaultTcaColumns(string $table): array
    {
        return [

            'starttime' => [
                'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
                'config' => [
                    'type' => 'datetime',
                    'eval' => 'int',
                    'default' => 0,
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],

            'endtime' => [
                'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
                'config' => [
                    'type' => 'datetime',
                    'eval' => 'int',
                    'default' => 0,
                    'range' => [
                        'upper' => mktime(0, 0, 0, 1, 1, 2038),
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],

            'sys_language_uid' => [
                'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
                'config' => [
                    'type' => 'language',
                ],
            ],

            'l10n_parent' => [
                'displayCond' => 'FIELD:sys_language_uid:>:0',
                'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        [
                            'label' => '',
                            'value' => 0,
                        ],
                    ],
                    'foreign_table' => $table,
                    'foreign_table_where' => 'AND' . $table . '.pid=###CURRENT_PID### AND ' . $table . '.sys_language_uid IN (-1,0)',
                    'default' => 0,
                ],

            ],

            'l10n_source' => [
                'displayCond' => 'FIELD:sys_language_uid:>:0',
                'label' => 'Translation source',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['label' => '', 'value' => 0],
                    ],
                    'foreign_table' => $table,
                    'foreign_table_where' => 'AND' . $table . '.pid=###CURRENT_PID### AND ' . $table . '.uid!=###THIS_UID###',
                    'default' => 0,
                ],
            ],

            'l10n_diffsource' => [
                'config' => [
                    'type' => 'passthrough',
                    'default' => '',
                ],
            ],

            'hidden' => [
                'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
                'config' => [
                    'type' => 'check',
                ],
            ],
        ];
    }
}
