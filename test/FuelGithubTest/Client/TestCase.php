<?php
/**
 *
 */

/**
 * @namespace
 */
namespace FuelGithubTest\Client;

use \PHPUnit_Framework_TestCase as PHPUnit,
    FuelGithub\Client\GithubProxy,
    Zend\Http\Client;

/**
 *
 *
 */
class TestCase extends PHPUnit
{

    public $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = new GithubProxy();

        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === false) {
            $mockAdapter   = new Client\Adapter\Test();
            $this->service->getHttpClient()->setAdapter($mockAdapter);
        }
    }

    public function cacheResponse($method, array $args)
    {
        $cacheFile = $this->getCacheFile($method, $args);
        if (file_exists($cacheFile)) {
            return;
        }

        $client   = $this->service->getHttpClient();
        $content  = $client->getResponse()->toString();
        file_put_contents($cacheFile, $content);
    }

    public function getCacheFile($method, array $args)
    {
        $cacheKey = md5($method . serialize($args));
        return dirname(__FILE__) . '/../../_assets/' . $cacheKey;
    }

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