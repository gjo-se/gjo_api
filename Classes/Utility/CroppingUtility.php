<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Utility;

final class CroppingUtility
{
    public static function setCropVariants(string $table, string $column): void
    {
        $defaultCropSettings = self::getBackendDefaultCropVariants();
        $lll = 'LLL:EXT:gjo_site_package/Resources/Private/Language/ContentElements.xlf:';

        $cropVariants = [
            'mobile' => 'cropVariant.mobile',
            'tablet' => 'cropVariant.tablet',
            'laptop' => 'cropVariant.laptop',
            'desktop' => 'cropVariant.desktop',
            'wideScreen' => 'cropVariant.wideScreen',
        ];

        foreach ($cropVariants as $variant => $label) {
            $cropSettings = $defaultCropSettings;
            $cropSettings['title'] = $lll . $label;
            $GLOBALS['TCA'][$table]['columns'][$column]['config']['overrideChildTca']['columns']['crop']['config']['cropVariants'][$variant] = $cropSettings;
        }
    }

    /**
     * @return array{
     *     title: string,
     *     allowedAspectRatios: array<string, array{title: string, value: float}>,
     *     selectedRatio: string,
     *     cropArea: array{x: float, y: float, width: float, height: float}
     * }
     */
    private static function getBackendDefaultCropVariants(): array
    {
        return [
            'title' => 'LLL:EXT:gjo_site_package/Resources/Private/Language/Backend.xlf:option.default',
            'allowedAspectRatios' => [
                '1:1' => [
                    'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:wizard.ratio.1_1',
                    'value' => 1.0,
                ],
                '4:3' => [
                    'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:wizard.ratio.4_3',
                    'value' => 4 / 3,
                ],
                '3:4' => [
                    'title' => '3:4',
                    'value' => 3 / 4,
                ],
                '16:9' => [
                    'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:wizard.ratio.16_9',
                    'value' => 16 / 9,
                ],
                '21:9' => [
                    'title' => '21:9',
                    'value' => 21 / 9,
                ],
                'NaN' => [
                    'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:wizard.ratio.free',
                    'value' => 0.0,
                ],
            ],
            'selectedRatio' => 'NaN',
            'cropArea' => [
                'x' => 0.0,
                'y' => 0.0,
                'width' => 1.0,
                'height' => 1.0,
            ],
        ];
    }

    /**
     * @return array{
     *     cropVariant: string,
     *     media: string,
     *     srcset: int[]
     * }[]
     */
    public static function getDefaultBreakpoints(): array
    {
        return [
            [
                'cropVariant' => 'wideScreen',
                'media' => '(min-width: 1200px)',
                'srcset' => [1100],
            ],
            [
                'cropVariant' => 'desktop',
                'media' => '(min-width: 992px)',
                'srcset' => [950],
            ],
            [
                'cropVariant' => 'laptop',
                'media' => '(min-width: 768px)',
                'srcset' => [720],
            ],
            [
                'cropVariant' => 'tablet',
                'media' => '(min-width: 576px)',
                'srcset' => [540],
            ],
            [
                'cropVariant' => 'mobile',
                'media' => '(min-width: 300px)',
                'srcset' => [350],
            ],
        ];
    }
}
