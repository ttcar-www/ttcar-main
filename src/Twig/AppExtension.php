<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('since', [$this, 'formatDate']),
        ];
    }

    public function formatDate(\DateTime $dt)
    {
        $now = new \DateTime();

        return $dt->diff($now)->format('%d');
    }
}