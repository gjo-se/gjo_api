<?php

declare(strict_types=1);

namespace GjoSe\GjoApi\Utility;

use TYPO3\CMS\Core\Core\Environment;

final class EnvironmentUtility extends Environment
{
    public static function getContextString(): string
    {
        return self::getContext()->isDevelopment() ? 'Development' :
            (self::getContext()->isTesting() ? 'Testing' : 'Production');
    }
}
