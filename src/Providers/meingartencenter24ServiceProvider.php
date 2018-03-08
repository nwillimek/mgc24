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
        //twig replacement        
        $eventDispatcher->listen('IO.tpl.category.item', function(TemplateContainer $container, $templateData) {
            $container->setTemplate("meingartencenter24::Category.Item.CategoryItem");
            return false;
        });

        $eventDispatcher->listen('IO.tpl.home', function(TemplateContainer $container, $templateData) {
            $container->setTemplate("meingartencenter24::Homepage.Homepage");
            return false;
        });

        //partial replacement
        $eventDispatcher->listen('IO.init.templates', function (Partial $partial) {
            $partial->set('header', 'meingartencenter24::PageDesign.Partials.Header.Header');
            $partial->set('footer', 'meingartencenter24::PageDesign.Partials.Footer');
            $partial->set('page-design', 'meingartencenter24::PageDesign.PageDesign');

        }, self::EVENT_LISTENER_PRIORITY);
        

        //vue components replacement
        $eventDispatcher->listen('IO.Component.Import', function(ComponentContainer $componentContainer) { 
            if($componentContainer->getOriginComponentTemplate() == 'Ceres::Customer.Components.UserLoginHandler') 
            {
                $componentContainer->setNewComponentTemplate('meingartencenter24::Customer.Components.UserLoginHandler');
            } 
            if($componentContainer->getOriginComponentTemplate() == 'Ceres::ItemList.Components.CategoryItem') 
            {
                    $componentContainer->setNewComponentTemplate('meingartencenter24::ItemList.Components.CategoryItem');
            }
            if($componentContainer->getOriginComponentTemplate() == 'Ceres::Item.Components.SingleItem') 
            {
                $componentContainer->setNewComponentTemplate('meingartencenter24::Item.Components.SingleItem');
            } 
        }, self::EVENT_LISTENER_PRIORITY);

    }
}