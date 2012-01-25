<?php

/**
 * @namespace
 */
namespace FuelGithub\Client;

use Zend\Http\Client as HttpClient,
    FuelGithub\Module as FuelGithub;

/**
 *
 */
class GithubProxy
{
    const GITHUB_SERVICE_PROTOCOL = 'https://';
    const GITHUB_SERVICE_URI = 'api.github.com';

    /**
     *
     *
     * @var \Zend\Http\Client|null
     */
    protected $httpClient;

    /**
     *
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
     * @var array
     */
    protected $subApiParts = array(

    );

    /**
     * @var null|string
     */
    protected $currentApiPart;

    /**
     * @var array
     */
    protected $instances = array(

    );

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
     *
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
        //\Zend\Debug::dump(self::GITHUB_SERVICE_PROTOCOL.self::GITHUB_SERVICE_URI.$url);
        return self::GITHUB_SERVICE_PROTOCOL.self::GITHUB_SERVICE_URI.$url;
    }

    /**
     *
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
            if (get_class($this) != 'FuelGithub\Client\GithubProxy') {
                $class = get_class($this).'\\'.ucfirst($name);
            } else {
                $class = __NAMESPACE__.'\\'.ucfirst($name);
            }
            $this->instances[$name] = new $class();
            $this->instances[$name]->setHttpClient($this->getHttpClient());
        }

        return $this->instances[$name];
    }
}