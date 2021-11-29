<?php

namespace App\Twig;

use Symfony\Component\Intl\Intl;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CountryExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('country_name', [$this, 'decodeCountryCode']),
        ];
    }

    public function decodeCountryCode(string $countryCode, string $locale = 'en')
    {
        \Locale::setDefault($locale);
        $countryName = '';
        if ($countryCode) {
            $countryName = Intl::getRegionBundle()->getCountryName($countryCode);
        }

        return $countryName ?? $countryCode;
    }
}
