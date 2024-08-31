<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Service\Template;

use GjoSe\GjoApi\Service\Site\SiteSettingsService;
use TYPO3\CMS\Fluid\View\StandaloneView;

final readonly class StandaloneViewService
{
    public function __construct(
        private StandaloneView $standaloneView,
        private SiteSettingsService $siteSettingsService
    ) {}

    // @todo-next-iteration:
    // hardcode Index - better ...SpreadOperator?
    public function configureStandaloneView(string $template = ''): StandaloneView
    {
        $this->standaloneView->setTemplatePathAndFilename(
            $this->siteSettingsService->getTemplateRootPath() . $template
        );
        $this->standaloneView->setPartialRootPaths([
            $this->siteSettingsService->getPartialRootPath(),
            $this->siteSettingsService->getPartialRootPath(1),
            $this->siteSettingsService->getPartialRootPath(2),
        ]);

        return $this->standaloneView;
    }
}
