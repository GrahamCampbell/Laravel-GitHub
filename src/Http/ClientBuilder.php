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
use Psr\Cache\CacheItemInterface;
use ReflectionClass;

/**
 * This is the client builder class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ClientBuilder extends Builder
{
    /**
     * Add a cache plugin to cache responses locally.
     *
     * @param \Psr\Cache\CacheItemInterface $cachePool
     * @param array                         $config
     *
     * @return void
     */
    public function addCache(CacheItemPoolInterface $cachePool, array $config = [])
    {
        $this->setCachePlugin($cachePool, $config['generator'] ?? null, $config['lifetime'] ?? null);

        $this->httpClientModified = true;
    }

    /**
     * Add a cache plugin to cache responses locally.
     *
     * @param \Psr\Cache\CacheItemInterface                                     $cachePool
     * @param \Http\Client\Common\Plugin\Cache\Generator\CacheKeyGenerator|null $generator
     * @param int|null                                                          $lifetime
     *
     * @return void
     */
    protected function setCachePlugin(CacheItemPoolInterface $cachePool, CacheKeyGenerator $generator = null, int $lifetime = null)
    {
        $prop = (new ReflectionClass($this))->getProperty('cachePlugin');

        $prop->setAccessible(true);

        $prop->setValue($this, new CachePlugin($cachePool, $this->getStreamFactory(), $generator, $lifetime));
    }

    /**
     * Get the internal stream factory.
     *
     * @return \Http\Message\StreamFactory
     */
    protected function getStreamFactory()
    {
        $prop = (new ReflectionClass($this))->getProperty('streamFactory');

        $prop->setAccessible(true);

        return $prop->getValue($this);
    }
}
