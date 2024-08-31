<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Service\Site;

use GjoSe\GjoApi\Service\Request\RequestService;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Routing\SiteMatcher;
use TYPO3\CMS\Core\Routing\SiteRouteResult;
use TYPO3\CMS\Core\Site\Entity\NullSite;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class AbstractSiteService
{
    public function getSite(?ServerRequestInterface $request = null): ?SiteInterface
    {
        if (!$request instanceof ServerRequestInterface) {
            /** @var RequestService $requestService */
            $requestService = GeneralUtility::makeInstance(RequestService::class);
            $request = $requestService->getRequest();
        }

        $site = $request->getAttribute('site');
        if (!$site || is_a($site, NullSite::class)) {
            $matcher = GeneralUtility::makeInstance(SiteMatcher::class);
            /** @var SiteRouteResult $routeResult */
            $routeResult = $matcher->matchRequest($request);
            $site = $routeResult->getSite();
        }

        return $site;
    }
}
