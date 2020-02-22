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

namespace GrahamCampbell\Tests\GitHub\Cache;

use GrahamCampbell\GitHub\Cache\ConnectionFactory;
use GrahamCampbell\GitHub\Cache\Connector\IlluminateConnector;
use GrahamCampbell\TestBench\AbstractTestCase;
use Illuminate\Contracts\Cache\Factory;
use InvalidArgumentException;
use Mockery;
use Psr\Cache\CacheItemPoolInterface;

/**
 * This is the cache connection factory test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ConnectionFactoryTest extends AbstractTestCase
{
    public function testMake()
    {
        $factory = $this->getMockedFactory();

        $return = $factory->make(['name' => 'foo', 'driver' => 'illuminate', 'connector' => 'redis']);

        $this->assertInstanceOf(CacheItemPoolInterface::class, $return);
    }

    public function testCreateIlluminateConnector()
    {
        $factory = new ConnectionFactory(Mockery::mock(Factory::class));

        $return = $factory->createConnector(['name' => 'foo', 'driver' => 'illuminate', 'connector' => 'redis']);

        $this->assertInstanceOf(IlluminateConnector::class, $return);
    }

    public function testCreateEmptyDriverConnector()
    {
        $factory = new ConnectionFactory(Mockery::mock(Factory::class));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A driver must be specified.');

        $factory->createConnector([]);
    }

    public function testCreateUnsupportedDriverConnector()
    {
        $factory = new ConnectionFactory(Mockery::mock(Factory::class));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported driver [unsupported].');

        $factory->createConnector(['driver' => 'unsupported']);
    }

    protected function getMockedFactory()
    {
        $cache = Mockery::mock(Factory::class);

        $mock = Mockery::mock(ConnectionFactory::class.'[createConnector]', [$cache]);

        $connector = Mockery::mock(IlluminateConnector::class, [$cache]);

        $connector->shouldReceive('connect')->once()
            ->with(['name' => 'foo', 'driver' => 'illuminate', 'connector' => 'redis'])
            ->andReturn(Mockery::mock(CacheItemPoolInterface::class));

        $mock->shouldReceive('createConnector')->once()
            ->with(['name' => 'foo', 'driver' => 'illuminate', 'connector' => 'redis'])
            ->andReturn($connector);

        return $mock;
    }
}
