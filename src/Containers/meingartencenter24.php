<?php

namespace meingartencenter24\Containers;

use Plenty\Plugin\Templates\Twig;

class meingartencenter24
{
    public function call(Twig $twig):string
    {
        return $twig->render('meingartencenter24::meingartencenter24');
    }
}
