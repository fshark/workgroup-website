<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('shuffle', [$this, 'shuffle']),
        ];
    }

    public function shuffle($input): array
    {
        if (is_object($input) && method_exists($input, 'toArray')) {
            $input = $input->toArray();
        }

        shuffle($input);

        return $input;
    }
}
