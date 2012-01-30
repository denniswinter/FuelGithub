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

use FuelGithub\Client,
    Zend\Json\Json;

/**
 * Reflects Githubs User-Emails API.
 *
 * @category   FuelGithub
 * @package    FuelGithub_Client
 * @subpackage User
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */
class Emails extends Client\GithubClient
{

    /**
     * Gets emails, registered by the authenticated user
     *
     * @return bool|mixed
     */
    public function get()
    {
        $response = $this->request('/user/emails');
        if ($response->isOk()) {
            return Json::decode($response->getBody());
        }
        return false;
    }

    /**
     * Adds one or more email addresses to the users profile
     *
     * @param  string|array $emailAddresses
     * @return bool|Email
     */
    public function add($emailAddresses)
    {
        if (!is_array($emailAddresses)) {
            $emailAddresses = array($emailAddresses);
        }
        $response = $this->request('/user/emails', 'POST', $emailAddresses);
        if ($response->getStatusCode() === 201) {
            return Json::decode($response->getBody());
        }
        return false;
    }

    /**
     * Deletes one or more email addresses from authenticated users profile
     *
     * @param  string|array $emailAddresses
     * @return bool
     */
    public function delete($emailAddresses)
    {
        if (!is_array($emailAddresses)) {
            $emailAddresses = array($emailAddresses);
        }
        $response = $this->request('/user/emails', 'DELETE', $emailAddresses);
        if ($response->getStatusCode() === 204) {
            return $this;
        }
        return false;
    }
}