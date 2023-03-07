<?php

declare(strict_types=1);

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\GitHub\Cache;

use GrahamCampbell\BoundedCache\BoundedCacheInterface;
use GrahamCampbell\GitHub\Cache\ConnectionFactory;
use GrahamCampbell\GitHub\Cache\Connector\IlluminateConnector;
use GrahamCampbell\TestBench\AbstractTestCase;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Cache\Factory;
use InvalidArgumentException;
use Mockery;

/**
 * This is the cache connection factory test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class ConnectionFactoryTest extends AbstractTestCase
{
    public function testMake(): void
    {
        $cache = Mockery::mock(Factory::class);
        $cache->shouldReceive('store')->once()->with('redis')->andReturn(Mockery::mock(Repository::class));
        $factory = new ConnectionFactory($cache);

        $return = $factory->make(['name' => 'foo', 'driver' => 'illuminate', 'connector' => 'redis']);

        self::assertInstanceOf(BoundedCacheInterface::class, $return);
    }

    public function testCreateIlluminateConnector(): void
    {
        $factory = new ConnectionFactory(Mockery::mock(Factory::class));

        $return = $factory->createConnector(['name' => 'foo', 'driver' => 'illuminate', 'connector' => 'redis']);

        self::assertInstanceOf(IlluminateConnector::class, $return);
    }

    public function testCreateEmptyDriverConnector(): void
    {
        $factory = new ConnectionFactory(Mockery::mock(Factory::class));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A driver must be specified.');

        $factory->createConnector([]);
    }

    public function testCreateUnsupportedDriverConnector(): void
    {
        $factory = new ConnectionFactory(Mockery::mock(Factory::class));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported driver [unsupported].');

        $factory->createConnector(['driver' => 'unsupported']);
    }
}
