<?php
/**
 * User: krona
 * Date: 6/11/14
 * Time: 5:24 AM
 */

namespace Arilas\KronaBundle;


use Doctrine\Common\Annotations\AnnotationRegistry;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        AnnotationRegistry::registerLoader(
            function ($class) {
                return class_exists($class);
            }
        );
    }
    
    public function getConfig()
    {
        return require_once __DIR__ . '/Resources/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
} 