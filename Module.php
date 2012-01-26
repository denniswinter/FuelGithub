<?php
/**
 * FuelGithub.
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@4expressions.com so I can send you a copy immediately.
 *
 * @category   FuelGithub
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */

/**
 * @namespace
 */
namespace FuelGithub;

use Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider,
    Zend\Module\Manager;

/**
 * Module entry point.
 *
 * @category   FuelGithub
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */
class Module implements AutoloaderProvider
{
    /**
     * @var array
     */
    protected static $options = array();

    /**
     * Instantiate the module
     *
     * @param \Zend\Module\Manager $moduleManager
     */
    public function init(Manager $moduleManager)
    {
        $moduleManager->events()->attach('loadModules.post', array($this, 'modulesLoaded'));
        //$events = StaticEventManager::getInstance();
        //$events->attach('bootstrap', 'bootstrap', array($this, 'bootstrap'));
    }

    /**
     * Returns configuration for instantiating the autoloader
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