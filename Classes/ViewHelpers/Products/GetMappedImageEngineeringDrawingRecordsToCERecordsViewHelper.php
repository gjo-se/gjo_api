<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\ViewHelpers\Products;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

final class GetMappedImageEngineeringDrawingRecordsToCERecordsViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'imageEngineeringDrawings',
            ObjectStorage::class,
            'ImageEngineeringDrawing',
            true
        );
    }

    /**
     * @return array<int, array{'data': array{'productHeader': string, 'imageDescription': string}, 'image': FileReference}>
     */
    public function render(): array
    {
        $imageEngineeringDrawingRecords = $this->arguments['imageEngineeringDrawings'];

        $mappedRecords = [];
        if ($imageEngineeringDrawingRecords instanceof ObjectStorage) {

            foreach ($imageEngineeringDrawingRecords as $key => $record) {
                /** @var FileReference $record */
                $mappedRecords[$key]['data']['productHeader'] = $record->getOriginalResource()->getTitle();
                $mappedRecords[$key]['data']['imageDescription'] = $record->getOriginalResource()->getDescription();
                $mappedRecords[$key]['image'] = $record;

            }
        }

        return $mappedRecords;
    }
}
