<?php

declare(strict_types=1);

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
use GrahamCampbell\GitHub\Auth\AuthenticatorFactory;
use GrahamCampbell\GitHub\Cache\ConnectionFactory;
use GrahamCampbell\GitHub\Http\ClientBuilder;
use Http\Client\Common\Plugin\RetryPlugin;
use Illuminate\Support\Arr;
use InvalidArgumentException;

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
     * @var \GrahamCampbell\GitHub\Auth\AuthenticatorFactory
     */
    protected $auth;

    /**
     * The cache factory instance.
     *
     * @var \GrahamCampbell\GitHub\Cache\ConnectionFactory
     */
    protected $cache;

    /**
     * Create a new github factory instance.
     *
     * @param \GrahamCampbell\GitHub\Auth\AuthenticatorFactory $auth
     * @param \GrahamCampbell\GitHub\Cache\ConnectionFactory   $cache
     *
     * @return void
     */
    public function __construct(AuthenticatorFactory $auth, ConnectionFactory $cache)
    {
        $this->auth = $auth;
        $this->cache = $cache;
    }

    /**
     * Make a new github client.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return \Github\Client
     */
    public function make(array $config)
    {
        $client = new Client($this->getBuilder($config), Arr::get($config, 'version'), Arr::get($config, 'enterprise'));

        if (!array_key_exists('method', $config)) {
            throw new InvalidArgumentException('The github factory requires an auth method.');
        }

        if ($config['method'] === 'none') {
            return $client;
        }

        return $this->auth->make($config['method'])->with($client)->authenticate($config);
    }

    /**
     * Get the http client builder.
     *
     * @param string[] $config
     *
     * @return \GrahamCampbell\GitHub\Http\ClientBuilder
     */
    protected function getBuilder(array $config)
    {
        $builder = new ClientBuilder();

        if ($backoff = Arr::get($config, 'backoff')) {
            $builder->addPlugin(new RetryPlugin(['retries' => $backoff === true ? 2 : $backoff]));
        }

        if (is_array($cache = Arr::get($config, 'cache', false))) {
            $builder->addCache($this->cache->make($cache));
        }

        return $builder;
    }
}
