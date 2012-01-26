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
    );

    /**
     * Gets user data from Githubs User API, if no $username is provided,
     * the authenticated users data will be returned.
     *
     * If there is no authenticated user a FuelGithub\Client\Exception\RuntimeException is thrown.
     *
     * @param  null|string $username
     * @return bool|mixed
     * @throws FuelGithub\Client\Exception\RuntimeException
     */
    public function get($username = null)
    {
        if ($username !== null) {
            $response = $this->request('/users/' . $username);
        } else {
            if (!FuelGithub::getOption('username') || !FuelGithub::getOption('password')) {
                $message  = "No credentials are provided. Please make sure to
                    provide authentication credentials or use the public API correctly";
                throw new Exception\RuntimeException($message);
            }
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

    /**
     * Get followers, whether with provided $username or based on the authenticated user
     *
     * @param  null|string $username
     * @return bool|mixed
     */
    public function getFollowers($username = null)
    {
        if ($username !== null) {
            $response = $this->request('/users/' . $username . '/followers');
        } else {
            $response = $this->request('/user/followers');
        }
        if ($response->isSuccess()) {
            return Json::decode($response->getBody());
        }
        return false;
    }

    /**
     * Get following, whether with provided $username or based on the authenticated user
     *
     * @param  null|string $username
     * @return bool|mixed
     */
    public function getFollowing($username = null)
    {
        if ($username !== null) {
            $response = $this->request('/users/' . $username . '/following');
        } else {
            $response = $this->request('/user/following');
        }
        if ($response->isSuccess()) {
            return (Json::decode($response->getBody()));
        }
        return false;
    }

    /**
     * Proves, if a user with $username is following the authenticated user.
     *
     * Works only, if valid credentials are provided
     *
     * @param  string $username
     * @return bool
     */
    public function isFollowing($username)
    {
        $response = $this->request('/user/following/' . $username);
        if ($response->getStatusCode() === 204) {
            return true;
        }
        return false;
    }

    /**
     * Follows a user with $username
     *
     * Works only, if valid credentials are provided
     *
     * @param  string $username
     * @return bool|User
     */
    public function follow($username)
    {
        $response = $this->request('/user/following/' . $username, 'PUT');
        if ($response->getStatusCode() === 204) {
            return $this;
        }
        return false;
    }

    /**
     * Unfollows a user with $username
     *
     * Works only, if valid credentials are provided
     *
     * @param  string $username
     * @return bool|User
     */
    public function unfollow($username)
    {
        $response = $this->request('/user/following/' . $username, 'DELETE');
        if ($response->getStatusCode() === 204) {
            return $this;
        }
        return false;
    }
}