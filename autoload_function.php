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

return function($class) {
    static $map;
    if (!$map) {
        $map = include __DIR__ . '/autoload_classmap.php';
    }
    if (!isset($map[$class])) {
        return false;
    }
    return include $map[$class];
};