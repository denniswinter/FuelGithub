<?php
/**
 *
 */

/**
 * @namespace
 */
namespace FuelGithub;

use Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider,
    Zend\Module\Manager;

/**
 *
 *
 */
class Module implements AutoloaderProvider
{
    /**
     * @var array
     */
    protected static $options = array();

    /**
     * @param \Zend\Module\Manager $moduleManager
     */
    public function init(Manager $moduleManager)
    {
        $moduleManager->events()->attach('loadModules.post', array($this, 'modulesLoaded'));
        //$events = StaticEventManager::getInstance();
        //$events->attach('bootstrap', 'bootstrap', array($this, 'bootstrap'));
    }

    /**
     * Returns the autoloading configuration
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        );
    }

    /**
     * Returns the module configuration
     *
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Sets static::$options to Module options
     *
     * @param $e
     */
    public function modulesLoaded($e)
    {
        $config = $e->getConfigListener()->getMergedConfig();
        static::$options = $config['fuelgithub'];
    }

    /**
     * Returns module option
     *
     * @static
     * @param string $option
     * @return null|mixed
     */
    public static function getOption($option)
    {
        if (!isset(static::$options[$option])) {
            return null;
        }
        return static::$options[$option];
    }
}