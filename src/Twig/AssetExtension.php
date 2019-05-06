<?php

namespace App\Twig;

use App\Service\AssetService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AssetExtension extends AbstractExtension {
    public function getFilters() {
        return [
            new TwigFilter('asset', [$this, 'composeAssetUrl']),
        ];
    }

    public function composeAssetUrl(string $fileName) {
        return AssetService::DIRECTORY.DIRECTORY_SEPARATOR.$fileName;
    }
}
