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
 * @namespace
 */
namespace FuelGithubTest\Client;

use FuelGithubTest\Client\TestCase as FuelTestCase;

/**
 * Tests Githubs User API.
 *
 * @category   FuelGithub
 * @package    FuelGithub_Client
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */
class GithubClientTest extends FuelTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {

    }

    public function testConnectingSucceedsWithBasicAuth()
    {
        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === false) {
            $cachedResponse = $this->getCachedResponse(
                'user-auth',
                array()
            );
            $this->service->getHttpClient()->getAdapter()->setResponse($cachedResponse);
        }
        $response = $this->service->request('/user');
        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === true) {
            $this->cacheResponse(
                'user-auth',
                array()
            );
        }
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testConnectionSucceedsWithoutAuthOnPublicApi()
    {
        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === false) {
            $cachedResponse = $this->getCachedResponse(
                'user-without-auth-public-api',
                array(
                    'schacon'
                )
            );

            $this->service->getHttpClient()->getAdapter()->setResponse($cachedResponse);
        }
        $response = $this->service->request('/users/schacon');
        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === true) {
            $this->cacheResponse(
                'user-without-auth-public-api',
                array(
                    'schacon'
                )
            );
        }
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testResolvingToASubApiPartIsWorking()
    {
        $this->assertInstanceOf('FuelGithub\Client\User\Email', $this->service->user->email);
    }

    public function testResolvingOfAnApiPartThrowsExceptionIfInvalidApiPartIsProvided()
    {
        $this->setExpectedException('FuelGithub\Client\Exception\InvalidArgumentException');
        $this->service->users;
    }

    public function testResolvingOfASubApiPartThrowsExceptionIfInvalidApiPartIsProvided()
    {
        $this->setExpectedException('FuelGithub\Client\Exception\InvalidArgumentException');
        $this->service->user->emails;
    }

    public function testHttpClientEqualsInApiPart()
    {
        $basicHttpClient = $this->service->getHttpClient();
        $this->assertEquals($basicHttpClient, $this->service->user->getHttpClient());
    }

    public function testHttpClientEqualsInSubApiPart()
    {
        $basicHttpClient = $this->service->getHttpClient();
        $this->assertEquals($basicHttpClient, $this->service->user->email->getHttpClient());
    }

    public function testHttpClientMayGetInjectedToConstructor()
    {
        $httpClient = new \Zend\Http\Client();

        $newService = new \FuelGithub\Client\GithubClient($httpClient);
        $this->assertEquals($httpClient, $newService->getHttpClient());
    }
}