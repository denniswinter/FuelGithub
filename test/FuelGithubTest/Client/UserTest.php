<?php
/**
 *
 */

/**
 * @namespace
 */
namespace FuelGithubTest\Client;

use FuelGithubTest\Client\TestCase as FuelTestCase;


/**
 *
 *
 */
class UserTest extends FuelTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testFollowingTheUserApiWorks()
    {
        $userApiClient = $this->service->user;
        $this->assertInstanceOf('FuelGithub\Client\User', $userApiClient);
    }

    public function testUserApiGetsAuthorizedUsersDataWhenAuthenticated()
    {
        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === false) {
            $cachedResponse = $this->getCachedResponse(
                'user-api-get-authorized-users-data-when-authenticated-and-no-username-provided',
                array()
            );
            $this->service->getHttpClient()->getAdapter()->setResponse($cachedResponse);
        }
        $response = $this->service->user->get();
        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === true) {
            $this->cacheResponse(
                'user-api-get-authorized-users-data-when-authenticated-and-no-username-provided',
                array()
            );
        }
        $this->assertInstanceOf('stdClass', $response);
    }

    public function testUserApiGetsGivenUsersDataWhenAuthenticated()
    {
        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === false) {
            $cachedResponse = $this->getCachedResponse(
                'user-api-gets-given-users-data-when-authenticated-and-username-is-provided',
                array('schacon')
            );
            $this->service->getHttpClient()->getAdapter()->setResponse($cachedResponse);
        }
        $response = $this->service->user->get('schacon');
        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === true) {
            $this->cacheResponse(
                'user-api-gets-given-users-data-when-authenticated-and-username-is-provided',
                array('schacon')
            );
        }
        $this->assertInstanceOf('StdClass', $response);
    }
}