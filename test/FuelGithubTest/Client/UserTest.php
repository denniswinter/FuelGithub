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

    public function testUserApiGetUserReturnsFalseIfUsernameIsNotTaken()
    {
        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === false) {
            $cachedResponse = $this->getCachedResponse(
                'user-api-get-user-returns-false-if-username-is-not-taken',
                array('shacon')
            );
            $this->service->getHttpClient()->getAdapter()->setResponse($cachedResponse);
        }
        $response = $this->service->user->get('shacon');
        if (FUEL_GITHUB_ONLINE_TESTS_ENABLED === true) {
            $this->cacheResponse(
                'user-api-get-user-returns-false-if-username-is-not-taken',
                array('shacon')
            );
        }
        $this->assertFalse($response);
    }
}