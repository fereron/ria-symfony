<?php
declare(strict_types=1);

namespace Ria\Bundle\PostBundle\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FlagIconExtension extends AbstractExtension
{
    protected Environment $twig;

    private const LOCALE_ICON = [
        'en' => 'us'
    ];

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('flagIcon', [$this, 'renderFlagIcon'], ['is_safe' => ['all']])
        ];
    }

    public function renderFlagIcon($locale): string
    {
        $iconLanguage = array_key_exists($locale, self::LOCALE_ICON)
            ? self::LOCALE_ICON[$locale]
            : $locale;

        return sprintf('<i class="flag-icon flag-icon-%s"></i>', $iconLanguage);
    }
}