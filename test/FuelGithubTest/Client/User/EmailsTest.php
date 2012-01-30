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
 * @package    FuelGithub_Client_User
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */

/**
 * @namespace
 */
namespace FuelGithubTest\Client\User;

use FuelGithubTest\Client\TestCase as FuelTestCase;


/**
 * Tests Githubs User-Emails API.
 *
 * @category   FuelGithub
 * @package    FuelGithub_Client_User
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */
class EmailsTest extends FuelTestCase
{
    public function testFollowingTheUserEmailsApiWorks()
    {
        $userApiClient = $this->service->user->emails;
        $this->assertInstanceOf('FuelGithub\Client\User\Emails', $userApiClient);
    }


}