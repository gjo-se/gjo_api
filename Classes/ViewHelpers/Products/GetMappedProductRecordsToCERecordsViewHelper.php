<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\ViewHelpers\Products;

use GjoSe\GjoProducts\Domain\Model\ProductSet;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

final class GetMappedProductRecordsToCERecordsViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'productSet',
            ProductSet::class,
            'ProductSet',
            true
        );
    }

    /**
     * @return array<int, array{'data': array{'productHeader': string, 'productAdditionalInformation': string}, 'image': mixed}>
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): array {

        /** @var ProductSet $productSet */
        $productSet = $arguments['productSet'];
        $objectStorage = $productSet->getProductSetVariantGroups();

        $mappedRecords = [];
        foreach ($objectStorage as $productSetVariantGroup) {
            $products = $productSetVariantGroup->getProducts();
            foreach ($products as $key => $record) {
                $additionalInformation = '';
                if ($record->getArticleNumber() && $record->getAdditionalInformation()) {
                    $additionalInformation = $record->getArticleNumber() . ', ' . $record->getAdditionalInformation();
                }

                if ($record->getArticleNumber() && !$record->getAdditionalInformation()) {
                    $additionalInformation = $record->getArticleNumber();
                }

                if (!$record->getArticleNumber() && $record->getAdditionalInformation()) {
                    $additionalInformation = $record->getAdditionalInformation();
                }

                $mappedRecords[$key]['data']['productHeader'] = $record->getName();
                $mappedRecords[$key]['data']['productAdditionalInformation'] = $additionalInformation;
                $mappedRecords[$key]['image'] = $record->getImage();

            }
        }

        return $mappedRecords;
    }
}
