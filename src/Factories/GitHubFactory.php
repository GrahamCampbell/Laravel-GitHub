<?php

/**
 * This file is part of Laravel GitHub by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\GitHub\Factories;

use Github\Client;
use Github\HttpClient\CachedHttpClient;

/**
 * This is the github factory class.
 *
 * @package    Laravel-GitHub
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-GitHub/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-GitHub
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
     * @param  string  $path
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Make a new github client.
     *
     * @param  array  $config
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
        return new CachedHttpClient(array('cache_dir' => $this->path));
    }

    /**
     * Get the configuration data.
     *
     * @param  array  $config
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function getConfig(array $config)
    {
        if (!array_key_exists('token', $config)) {
            throw new \InvalidArgumentException('The github client requires configuration.');
        }

        return array_only($config, array('token'));
    }

    /**
     * Get the main client.
     *
     * @param  \Github\HttpClient\CachedHttpClient  $http
     * @param  array  $config
     * @return \Github\Client
     */
    protected function getClient(CachedHttpClient $http, array $config)
    {
        $client = new Client($http);

        $client->authenticate($config['token'], 'http_token');

        return $client;
    }
}
