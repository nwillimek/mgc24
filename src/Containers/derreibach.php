<?php

namespace derreibach\Containers;

use Plenty\Plugin\Templates\Twig;

class derreibach
{
    public function call(Twig $twig):string
    {
        return $twig->render('derreibach::derreibach');
    }
}
