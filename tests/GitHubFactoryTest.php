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

namespace GrahamCampbell\Tests\GitHub;

use Github\Client;
use GrahamCampbell\BoundedCache\BoundedCacheInterface;
use GrahamCampbell\GitHub\Auth\AuthenticatorFactory;
use GrahamCampbell\GitHub\Cache\ConnectionFactory;
use GrahamCampbell\GitHub\GitHubFactory;
use GrahamCampbell\GitHub\HttpClient\BuilderFactory;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory as GuzzlePsrFactory;
use Http\Client\Common\HttpMethodsClientInterface;
use Illuminate\Contracts\Cache\Factory;
use InvalidArgumentException;
use Mockery;

/**
 * This is the github factory test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class GitHubFactoryTest extends AbstractTestBenchTestCase
{
    public function testMakeStandard(): void
    {
        [$factory, $cache] = self::getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token']);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeStandardExplicitCache(): void
    {
        [$factory, $cache] = self::getFactory();

        $boundedCache = Mockery::mock(BoundedCacheInterface::class);
        $boundedCache->shouldReceive('getMaximumLifetime')->once()->with()->andReturn(42);

        $cache->shouldReceive('make')->once()->with(['name' => 'main', 'driver' => 'illuminate'])->andReturn($boundedCache);

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'cache' => ['name' => 'main', 'driver' => 'illuminate']]);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeStandardNamedCache(): void
    {
        [$factory, $cache] = self::getFactory();

        $boundedCache = Mockery::mock(BoundedCacheInterface::class);
        $boundedCache->shouldReceive('getMaximumLifetime')->once()->with()->andReturn(42);

        $cache->shouldReceive('make')->once()->with(['name' => 'main', 'driver' => 'illuminate', 'connection' => 'foo'])->andReturn($boundedCache);

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'cache' => ['name' => 'main', 'driver' => 'illuminate', 'connection' => 'foo']]);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeStandardNoCacheOrBackoff(): void
    {
        [$factory, $cache] = self::getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'cache' => false, 'backoff' => false]);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeStandardExplicitBackoff(): void
    {
        [$factory, $cache] = self::getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'backoff' => true]);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeStandardExplicitEnterprise(): void
    {
        [$factory, $cache] = self::getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'enterprise' => 'https://example.com/']);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeStandardExplicitVersion(): void
    {
        [$factory, $cache] = self::getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'version' => 'v4']);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeNoneMethod(): void
    {
        [$factory, $cache] = self::getFactory();

        $client = $factory->make(['method' => 'none']);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeInvalidMethod(): void
    {
        [$factory, $cache] = self::getFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported authentication method [bar].');

        $factory->make(['method' => 'bar']);
    }

    public function testMakeEmpty(): void
    {
        [$factory, $cache] = self::getFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The github factory requires an auth method.');

        $factory->make([]);
    }

    /**
     * @return array{0: GitHubFactory, 1: ConnectionFactory}
     */
    private static function getFactory(): array
    {
        $psrFactory = new GuzzlePsrFactory();

        $builder = new BuilderFactory(
            new GuzzleClient(['connect_timeout' => 10, 'timeout' => 30]),
            $psrFactory,
            $psrFactory,
        );

        $cache = Mockery::mock(ConnectionFactory::class);

        return [new GitHubFactory($builder, new AuthenticatorFactory(), $cache), $cache];
    }
}
