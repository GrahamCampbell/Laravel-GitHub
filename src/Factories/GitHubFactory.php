<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\GitHub\Factories;

use Github\Client;
use Github\HttpClient\CachedHttpClient;

/**
 * This is the github factory class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class GitHubFactory
{
    /**
     * The cache path.
     *
     * @var string
     */
    protected $path;

    /**
     * Create a new github factory instance.
     *
     * @param string $path
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Make a new github client.
     *
     * @param string[] $config
     *
     * @return \Github\Client
     */
    public function make(array $config)
    {
        $http = $this->getHttp();

        $config = $this->getConfig($config);

        return $this->getClient($http, $config);
    }

    /**
     * Get the http client.
     *
     * @return \Github\HttpClient\CachedHttpClient
     */
    protected function getHttp()
    {
        return new CachedHttpClient(['cache_dir' => $this->path]);
    }

    /**
     * Get the configuration data.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return string[]
     */
    protected function getConfig(array $config)
    {
        if (!array_key_exists('token', $config)) {
            throw new \InvalidArgumentException('The github client requires configuration.');
        }

        return array_only($config, ['token']);
    }

    /**
     * Get the main client.
     *
     * @param \Github\HttpClient\CachedHttpClient $http
     * @param string[]                            $config
     *
     * @return \Github\Client
     */
    protected function getClient(CachedHttpClient $http, array $config)
    {
        $client = new Client($http);

        $client->authenticate($config['token'], 'http_token');

        return $client;
    }
}
