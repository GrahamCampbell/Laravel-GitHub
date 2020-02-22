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

namespace GrahamCampbell\Tests\GitHub\Cache\Connector;

use GrahamCampbell\GitHub\Cache\Connector\IlluminateConnector;
use GrahamCampbell\TestBench\AbstractTestCase;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Cache\Factory;
use InvalidArgumentException;
use Mockery;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * This is the illuminate connector test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class IlluminateConnectorTest extends AbstractTestCase
{
    public function testConnectStandard()
    {
        $connector = $this->getIlluminateConnector();
        $repo = Mockery::mock(Repository::class);
        $connector->getCache()->shouldReceive('store')->once()->andReturn($repo);

        $this->assertInstanceOf(AdapterInterface::class, $connector->connect([]));
    }

    public function testConnectFull()
    {
        $connector = $this->getIlluminateConnector();
        $repo = Mockery::mock(Repository::class);
        $connector->getCache()->shouldReceive('store')->once()->with('redis')->andReturn($repo);

        $return = $connector->connect([
            'driver'    => 'illuminate',
            'connector' => 'redis',
            'key'       => 'bar',
            'ttl'       => 600,
        ]);

        $this->assertInstanceOf(AdapterInterface::class, $return);
    }

    public function testConnectNoCacheFactory()
    {
        $connector = new IlluminateConnector();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Illuminate caching support not available.');

        $connector->connect([]);
    }

    protected function getIlluminateConnector()
    {
        $cache = Mockery::mock(Factory::class);

        return new IlluminateConnector($cache);
    }
}
