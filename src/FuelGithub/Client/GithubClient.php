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
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */

/**
 * @namespace
 */
namespace FuelGithub\Client;

use Zend\Http\Client as HttpClient,
    FuelGithub\Module as FuelGithub;

/**
 * Base proxy class.
 *
 * @category   FuelGithub
 * @package    FuelGithub_Client
 * @copyright  Copyright (c) 2012 Dennis Winter <info@4expressions.com>
 * @license    New BSD License
 */
class GithubClient
{
    /**
     * @const string
     */
    const GITHUB_SERVICE_PROTOCOL = 'https://';
    /**
     * @const string
     */
    const GITHUB_SERVICE_URI = 'api.github.com';

    /**
     * HttpClient
     *
     * @var \Zend\Http\Client|null
     */
    protected $httpClient;

    /**
     * Available API parts
     *
     * @var array
     */
    protected $apiParts = array(
        'user',
        'orgs',
        'repos',
        'gists',
        'issues',
        'commits',
        'pulls'
    );

    /**
     * Current used API part
     *
     * @var null|string
     */
    protected $currentApiPart;

    /**
     * Array of instantiated API parts
     *
     * @var array
     */
    protected $instances = array();

    /**
     * Constructor
     *
     * May get HttpClient injected.
     *
     * @param null|\Zend\Http\Client $httpClient
     */
    public function __construct(HttpClient $httpClient = null)
    {
        if ($httpClient !== null) {
            $this->setHttpClient($httpClient);
        }
    }

    /**
     * Returns HttpClient
     *
     * @return \Zend\Http\Client
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->setHttpClient(new HttpClient());
        }

        return $this->httpClient;
    }

    /**
     * Sets HttpClient
     *
     * @param \Zend\Http\Client $httpClient
     * @return self
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * Performs a request on the Github API, based on the provided parameters:
     *
     * $url always marks the targeted URL
     * $httpVerb may be one of "GET", "POST", "PATCH", "DELETE" & "PUT"
     * $params is an array of additional parameters to send within the request
     *
     * @param string $url
     * @param string $httpVerb
     * @param array $params
     * @return \Zend\Http\Response
     */
    public function request($url, $httpVerb = 'GET', array $params = array())
    {
        if ($httpVerb === 'PATCH') {
            $httpVerb = 'POST';
        }

        $this->getHttpClient()
            ->setMethod($httpVerb)
            ->setUri($this->getServiceUrl($url));

        if (FuelGithub::getOption('auth_conf') == 'HTTP_BASIC') {
            $this->getHttpClient()
                ->setAuth(
                    FuelGithub::getOption('username'),
                    FuelGithub::getOption('password')
                );
        } elseif (FuelGithub::getOption('auth_conf') == 'OAUTH2') {
            $oauthToken = '';
            $this->getHttpClient()
                ->getRequest()
                ->headers()
                ->addHeaderLine('Authorization', 'token ' . $oauthToken);
        }

        $response = $this->getHttpClient()->send();
        return $response;
    }

    /**
     * Builds the URL string
     *
     * @param string $url
     * @return string
     */
    protected function getServiceUrl($url)
    {
        if (substr($url, 0, 1) != '/') {
            $url = '/'.$url;
        }
        return self::GITHUB_SERVICE_PROTOCOL.self::GITHUB_SERVICE_URI.$url;
    }

    /**
     * Use magic method for resolving API parts
     *
     * @param  string $name
     * @return GithubProxy
     * @throws Exception\InvalidArgumentException
     */
    public function __get($name)
    {
        $name = strtolower($name);
        if (!in_array($name, $this->apiParts)) {
            $message = "No API with name '%s'. Available API parts: [%s]";
            $message = sprintf($message, $name, implode(', ', $this->apiParts));
            throw new Exception\InvalidArgumentException($message);
        }
        if (!array_key_exists($name, $this->instances)
        || !($this->instances[$name] instanceof self)) {
            // Slightly hacked it in
            // Had some problems resolving additional sub API parts
            if (get_class($this) != 'FuelGithub\Client\GithubClient') {
                $class = get_class($this).'\\'.ucfirst($name);
            } else {
                $class = __NAMESPACE__.'\\'.ucfirst($name);
            }
            $this->instances[$name] = new $class($this->getHttpClient());
        }

        return $this->instances[$name];
    }

    /**
     * Checks if credentials are provided
     *
     * @TODO Need to refactor this, when updating to OAUTH2
     *
     * @throws Exception\BadCredentialsException
     */
    protected function checkForCredentials()
    {
        if (!FuelGithub::getOption('username') || !FuelGithub::getOption('password')) {
            $message  = "No credentials are provided. Please make sure to
                provide authentication credentials or use the public API correctly";
            throw new Exception\BadCredentialsException($message);
        }
    }
}