<?php

namespace FuelGithubTest\Client;

use FuelGithubTest\Client\TestCase as FuelTestCase;

class GithubProxyTest extends FuelTestCase
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

    public function testResolvingToASubSubApiIsWorking()
    {
        $this->assertInstanceOf('FuelGithub\Client\User\Email', $this->service->user->email);
    }

    public function testResolvingOfASubApiThrowsExceptionIfInvalidApiPartIsProvided()
    {
        $this->setExpectedException('FuelGithub\Client\Exception\InvalidArgumentException');
        $this->service->users;
    }

    public function testResolvingOfASubSubApiThrowsExceptionIfInvalidApiPartIsProvided()
    {
        $this->setExpectedException('FuelGithub\Client\Exception\InvalidArgumentException');
        $this->service->user->emails;
    }

    public function testHttpClientEqualsInSubApi()
    {
        $basicHttpClient = $this->service->getHttpClient();
        $this->assertEquals($basicHttpClient, $this->service->user->getHttpClient());
    }

    public function testHttpClientEqualsInSubSubApi()
    {
        $basicHttpClient = $this->service->getHttpClient();
        $this->assertEquals($basicHttpClient, $this->service->user->email->getHttpClient());
    }
}