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
 * @subpackage User
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */

/**
 * @namespace
 */
namespace FuelGithub\Client;

use Zend\Json\Json,
    FuelGithub\Client\Exception,
    FuelGithub\Module as FuelGithub;

/**
 * Reflects Githubs User API.
 *
 * @category   FuelGithub
 * @package    FuelGithub_Client
 * @subpackage User
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */
class User extends GithubClient
{

    /**
     * API parts, below the User API
     *
     * @var array
     */
    protected $apiParts = array(
        'email',
        'keys',
        'followers',
    );

    /**
     * Gets user data from Githubs User API, if no $username is provided,
     * the authenticated users data will be returned.
     *
     * If there is no authenticated user a FuelGithub\Client\Exception\RuntimeException is thrown.
     *
     * @param  null|string $username
     * @return bool|mixed
     * @throws FuelGithub\Client\Exception\BadCredentialException if no credentials are provided
     */
    public function get($username = null)
    {
        if ($username !== null) {
            $response = $this->request('/users/' . $username);
        } else {
            $this->checkForCredentials();
            $response = $this->request('/user');
        }
        if ($response->isSuccess()) {
            return (Json::decode($response->getBody()));
        }
        return false;
    }

    public function update(array $data)
    {

    }
}