<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\ViewHelpers\Products;

use GjoSe\GjoProducts\Domain\Model\ProductSetVariantGroup;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GetProductSetVariantFiltersViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'productSetVariantGroup',
            ProductSetVariantGroup::class,
            'ProductSet',
            true
        );
    }

    /**
     * @return array<string, array<int|string, int|string>>
     */
    public function render(): array
    {
        /** @var ProductSetVariantGroup $productSetVariantGroup */
        $productSetVariantGroup = $this->arguments['productSetVariantGroup'];
        $objectStorage = $productSetVariantGroup->getProductSetVariants();
        $variantFilters = [];

        foreach ($objectStorage as $productSetVariant) {

            if ($productSetVariant->getLength()) {
                $variantFilters['length'][$productSetVariant->getLength()] = $productSetVariant->getLength();
            }

            if ($productSetVariant->getVersion()) {
                $variantFilters['version'][$productSetVariant->getVersion()] = $productSetVariant->getVersion();
            }

            if ($productSetVariant->getMaterial()) {
                $variantFilters['material'][$productSetVariant->getMaterial()] = $productSetVariant->getMaterial();
            }
        }

        return $variantFilters;
    }
}
