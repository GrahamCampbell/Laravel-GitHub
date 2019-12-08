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

use Illuminate\Contracts\Cache\Repository;
use Psr\SimpleCache\CacheInterface;

/**
 * This is the PSR-16 cache class.
 *
 * The purpose of this class is to work around bugs present in Laravel
 * 5.5.0-5.5.47, 5.6.x and 5.7.x, and 5.8.0-5.8.32, and also to enforce a
 * maximum TTL on cache items.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Psr16Cache implements CacheInterface
{
    /**
     * The underlying cache instance.
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * The minimum cache time.
     *
     * @var int
     */
    protected $min;

    /**
     * The maximum cache time.
     *
     * @var int
     */
    protected $max;

    /**
     * Create a PSR-16 cache instance.
     *
     * @param \Illuminate\Contracts\Cache\Repository $cache
     * @param int                                    $min
     * @param int                                    $max
     *
     * @return void
     */
    public function __construct(Repository $cache, int $min, int $max)
    {
        $this->cache = $cache;
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Computes the TTL to use.
     *
     * @param null|int|\DateInterval $ttl
     *
     * @return int
     */
    protected function computeTtl($ttl)
    {
        return TtlHelper::computeTtl($this->min, $this->max, $ttl);
    }

    /**
     * Fetches a value from the cache.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->cache->get($key, $default);
    }

    /**
     * Persists data in the cache, uniquely referenced by a key.
     *
     * @param string                 $key
     * @param mixed                  $value
     * @param null|int|\DateInterval $ttl
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->cache->put($key, $value, $this->computeTtl($ttl));
    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string $key
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function delete($key)
    {
        return $this->cache->forget($key);
    }

    /**
     * Wipes clean the entire cache's keys.
     *
     * @return bool
     */
    public function clear()
    {
        return $this->cache->clear();
    }

    /**
     * Obtains multiple cache items by their unique keys.
     *
     * @param iterable $keys
     * @param mixed    $default
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return iterable
     */
    public function getMultiple($keys, $default = null)
    {
        $defaults = [];

        foreach ($keys as $key) {
            $defaults[$key] = $default;
        }

        return $this->cache->many($defaults);
    }

    /**
     * Persists a set of key => value pairs in the cache.
     *
     * @param iterable               $values
     * @param null|int|\DateInterval $ttl
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function setMultiple($values, $ttl = null)
    {
        $values = is_array($values) ? $values : iterator_to_array($values);

        return $this->cache->putMany($values, $this->computeTtl($ttl));
    }

    /**
     * Deletes multiple cache items in a single operation.
     *
     * @param iterable $keys
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function deleteMultiple($keys)
    {
        return $this->cache->deleteMultiple($keys);
    }

    /**
     * Determines whether an item is present in the cache.
     *
     * @param string $key
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->cache->has($key);
    }
}
