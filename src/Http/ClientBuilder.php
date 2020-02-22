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

namespace GrahamCampbell\GitHub\Http;

use Github\HttpClient\Builder;
use Http\Client\Common\Plugin\Cache\Generator\CacheKeyGenerator;
use Http\Client\Common\Plugin\Cache\Generator\HeaderCacheKeyGenerator;
use Http\Client\Common\Plugin\CachePlugin;
use Psr\Cache\CacheItemPoolInterface;
use ReflectionClass;

/**
 * This is the client builder class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class ClientBuilder extends Builder
{
    /**
     * The default cache lifetime of 48 hours.
     *
     * @var int
     */
    const DEFAULT_CACHE_LIFETIME = 172800;

    /**
     * Add a cache plugin to cache responses locally.
     *
     * @param \Psr\Cache\CacheItemPoolInterface $cachePool
     * @param array                             $config
     *
     * @return void
     */
    public function addCache(CacheItemPoolInterface $cachePool, array $config = [])
    {
        $this->setCachePlugin(
            $cachePool,
            $config['generator'] ?? new HeaderCacheKeyGenerator(['Authorization', 'Cookie', 'Accept', 'Content-type']),
            $config['lifetime'] ?? self::DEFAULT_CACHE_LIFETIME
        );

        $this->setPropertyValue('httpClientModified', true);
    }

    /**
     * Add a cache plugin to cache responses locally.
     *
     * @param \Psr\Cache\CacheItemPoolInterface                            $cachePool
     * @param \Http\Client\Common\Plugin\Cache\Generator\CacheKeyGenerator $generator
     * @param int                                                          $lifetime
     *
     * @return void
     */
    private function setCachePlugin(CacheItemPoolInterface $cachePool, CacheKeyGenerator $generator, int $lifetime)
    {
        $stream = $this->getPropertyValue('streamFactory');

        $options = ['cache_lifetime' => $lifetime, 'cache_key_generator' => $generator];

        $this->setPropertyValue('cachePlugin', CachePlugin::clientCache($cachePool, $stream, $options));
    }

    /**
     * Get the value of the given private property on the builder.
     *
     * @param string $name
     *
     * @return mixed
     */
    private function getPropertyValue(string $name)
    {
        return self::getProperty($name)->getValue($this);
    }

    /**
     * Set the value of the given private property on the builder.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    private function setPropertyValue(string $name, $value)
    {
        self::getProperty($name)->setValue($this, $value);
    }

    /**
     * Get the builder reflection property for the given name.
     *
     * @param string $name
     *
     * @return \ReflectionProperty
     */
    private static function getProperty(string $name)
    {
        $prop = (new ReflectionClass(Builder::class))->getProperty($name);

        $prop->setAccessible(true);

        return $prop;
    }
}
