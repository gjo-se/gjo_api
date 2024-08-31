<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Service\Request;

use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class RequestService
{
    public function getRequest(): ServerRequest
    {
        return $GLOBALS['TYPO3_REQUEST'] ?? GeneralUtility::makeInstance(ServerRequest::class);
    }
}
