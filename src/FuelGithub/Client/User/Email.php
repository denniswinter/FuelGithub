<?php
/**
 *
 */

/**
 * @namespace
 */
namespace FuelGithub\Client\User;

use FuelGithub\Client,
    Zend\Json\Json;

/**
 *
 *
 */
class Email extends Client\GithubProxy
{

    /**
     *
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
     *
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
     *
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