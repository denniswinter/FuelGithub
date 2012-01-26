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
 * @package    FuelGithub_Client
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */

/**
 * @namespace
 */
namespace FuelGithubTest\Client;

use \PHPUnit_Framework_TestCase as PHPUnit,
    FuelGithub\Client\GithubClient,
    Zend\Http\Client;

/**
 * Ability to cache responses.
 *
 * @category   FuelGithub
 * @package    FuelGithub_Client
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */
class TestCase extends PHPUnit
{

    public $service;

    /**
     * Instantiates new Service client
     */
    public function setUp()
    {
        parent::setUp();

        $this->service = new GithubClient();

        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === false) {
            $mockAdapter   = new Client\Adapter\Test();
            $this->service->getHttpClient()->setAdapter($mockAdapter);
        }
    }

    /**
     * Caches response to file with name based on provided $method and $args
     *
     * @param string $method
     * @param array $args
     */
    public function cacheResponse($method, array $args)
    {
        $cacheFile = $this->getCacheFile($method, $args);
        if (file_exists($cacheFile)) {
            return;
        }

        $client   = $this->service->getHttpClient();
        $content  = $client->getLastRawResponse();
        file_put_contents($cacheFile, $content);
    }

    /**
     * Gets name of the cache file, based on provided $method and $args
     *
     * @param  string $method
     * @param  array $args
     * @return string
     */
    public function getCacheFile($method, array $args)
    {
        $cacheKey = md5($method . serialize($args));
        return dirname(__FILE__) . '/../../_assets/' . $cacheKey;
    }

    /**
     * Gets cached response from file with name based on provided $method and $args
     *
     * @param  string $method
     * @param  array $args
     * @return string
     * @throws \Exception
     */
    public function getCachedResponse($method, array $args)
    {
        $cacheFile = $this->getCacheFile($method, $args);

        if (!file_exists($cacheFile)) {
            throw new \Exception(sprintf(
                'Missing cache file for method "%s", args "%s"',
                $method,
                var_export($args, 1)
            ));
        }

        return file_get_contents($cacheFile);
    }
}