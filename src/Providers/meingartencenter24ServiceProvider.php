<?php

namespace meingartencenter24\Providers;

use IO\Extensions\Functions\Partial;
use IO\Helper\CategoryKey;
use IO\Helper\CategoryMap;
use IO\Helper\TemplateContainer;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ConfigRepository;
use IO\Helper\ComponentContainer;

class meingartencenter24ServiceProvider extends ServiceProvider
{
    const EVENT_LISTENER_PRIORITY = 99;
    /**
     * Register the service provider.
     */

    public function register() {
         
    }

    public function boot(Twig $twig, Dispatcher $eventDispatcher, ConfigRepository $config)
    {
        $eventDispatcher->listen('IO.Component.Import', function(ComponentContainer $componentContainer) { 
            if($componentContainer->getOriginComponentTemplate() == 'Ceres::Customer.Components.LoginView') {
                    $componentContainer->setNewComponentTemplate('meingartencenter24::Customer.Components.LoginView');
            } 
        }, self::EVENT_LISTENER_PRIORITY);

        $eventDispatcher->listen('IO.Component.Import', function(ComponentContainer $componentContainer) { 
            if($componentContainer->getOriginComponentTemplate() == 'Ceres::Customer.Components.GuestLogin') {
                    $componentContainer->setNewComponentTemplate('meingartencenter24::Customer.Components.GuestLogin');
            } 
        }, self::EVENT_LISTENER_PRIORITY);

    }
}