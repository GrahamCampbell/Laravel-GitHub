<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\GitHub;

use Github\Client;
use GrahamCampbell\GitHub\Authenticators\AuthenticatorFactory;
use Http\Client\Common\Plugin\RetryPlugin;
use Illuminate\Contracts\Cache\Repository;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItemPool;

/**
 * This is the github factory class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubFactory
{
    /**
     * The authenticator factory instance.
     *
     * @var \GrahamCampbell\GitHub\Authenticators\AuthenticatorFactory
     */
    protected $auth;

    /**
     * The illuminate cache instance.
     *
     * @var \Illuminate\Contracts\Cache\Repository|null
     */
    protected $cache;

    /**
     * Create a new github factory instance.
     *
     * @param \GrahamCampbell\GitHub\Authenticators\AuthenticatorFactory $auth
     * @param \Illuminate\Contracts\Cache\Repository|null                $cache
     *
     * @return void
     */
    public function __construct(AuthenticatorFactory $auth, Repository $cache = null)
    {
        $this->auth = $auth;
        $this->cache = $cache;
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
        $client = new Client();

        if ($version = array_get($config, 'version')) {
            $client->setOption('api_version', $version);
        }

        if ($enterprise = array_get($config, 'enterprise')) {
            $client->setEnterpriseUrl($enterprise);
        }

        if ($this->cache && array_get($config, 'cache') && class_exists(CacheItemPool::class)) {
            $client->addCache(new CacheItemPool($this->cache));
        }

        if (array_get($config, 'backoff')) {
            $client->addPlugin(new RetryPlugin(['retries' => 2]));
        }

        $client->clearHeaders();

        return $this->auth->make(array_get($config, 'method'))->with($client)->authenticate($config);
    }
}
