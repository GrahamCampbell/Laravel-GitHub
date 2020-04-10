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

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;

/**
 * This is the github manager class.
 *
 * @method \Github\Client connection(string|null $name)
 * @method \Github\Client reconnect(string|null $name)
 * @method void authenticate(string $tokenOrLogin, string|null $password = null, string|null $authMethod = null)
 * @method string getApiVersion()
 * @method void addCache(\Psr\Cache\CacheItemPoolInterface $cachePool, array $config = [])
 * @method void removeCache()
 * @method \Http\Client\Common\HttpMethodsClient getHttpClient()
 * @method \Psr\Http\Message\ResponseInterface|null getLastResponse()
 *
 * @mixin \Github\Client
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var \GrahamCampbell\GitHub\GitHubFactory
     */
    protected $factory;

    /**
     * Create a new github manager instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \GrahamCampbell\GitHub\GitHubFactory    $factory
     *
     * @return void
     */
    public function __construct(Repository $config, GitHubFactory $factory)
    {
        parent::__construct($config);
        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return \Github\Client
     */
    protected function createConnection(array $config)
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName()
    {
        return 'github';
    }

    /**
     * Get the configuration for a connection.
     *
     * @param string|null $name
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getConnectionConfig(string $name = null)
    {
        $config = parent::getConnectionConfig($name);

        if (is_string($cache = Arr::get($config, 'cache'))) {
            $config['cache'] = $this->getNamedConfig('cache', 'Cache', $cache);
        }

        return $config;
    }

    /**
     * Get the factory instance.
     *
     * @return \GrahamCampbell\GitHub\GitHubFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
