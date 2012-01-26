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
namespace FuelGithub\Client\User;

use FuelGithub\Client\GithubClient,
    Zend\Json\Json;

/**
 * Reflects Githubs User-Followers API.
 *
 * @category   FuelGithub
 * @package    FuelGithub_Client
 * @subpackage User
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */
class Followers extends GithubClient
{
    /**
     * Get followers, whether with provided $username or based on the authenticated user
     *
     * @param  null|string $username
     * @return bool|mixed
     * @throws FuelGithub\Client\Exception\BadCredentialException if no credentials are provided
     */
    public function getFollowers($username = null)
    {
        if ($username !== null) {
            $response = $this->request('/users/' . $username . '/followers');
        } else {
            $this->checkForCredentials();
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
     * @throws FuelGithub\Client\Exception\BadCredentialException if no credentials are provided
     */
    public function getFollowing($username = null)
    {
        if ($username !== null) {
            $response = $this->request('/users/' . $username . '/following');
        } else {
            $this->checkForCredentials();
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
     * @throws FuelGithub\Client\Exception\BadCredentialException if no credentials are provided
     */
    public function isFollowing($username)
    {
        $this->checkForCredentials();
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
     * @throws FuelGithub\Client\Exception\BadCredentialException if no credentials are provided
     */
    public function follow($username)
    {
        $this->checkForCredentials();
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
     * @throws FuelGithub\Client\Exception\BadCredentialException if no credentials are provided
     */
    public function unfollow($username)
    {
        $this->checkForCredentials();
        $response = $this->request('/user/following/' . $username, 'DELETE');
        if ($response->getStatusCode() === 204) {
            return $this;
        }
        return false;
    }
}