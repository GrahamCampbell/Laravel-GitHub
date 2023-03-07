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
use GrahamCampbell\GitHub\GitHubFactory;
use GrahamCampbell\GitHub\GitHubManager;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use Illuminate\Contracts\Config\Repository;
use Mockery;

/**
 * This is the github manager test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class GitHubManagerTest extends AbstractTestBenchTestCase
{
    public function testCreateConnection(): void
    {
        $config = ['token' => 'your-token'];

        $manager = self::getManager($config);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('github.default')->andReturn('main');

        self::assertSame([], $manager->getConnections());

        $return = $manager->connection();

        self::assertInstanceOf(Client::class, $return);

        self::assertArrayHasKey('main', $manager->getConnections());
    }

    public function testConnectionCache(): void
    {
        $config = ['token' => 'your-token', 'cache' => 'redis'];

        $cache = ['driver' => 'illuminate', 'connection' => 'redis', 'min' => 123, 'max' => 1234];

        $manager = self::getManagerWithCache($config, $cache);

        self::assertSame([], $manager->getConnections());

        $return = $manager->connection('oauth');

        self::assertInstanceOf(Client::class, $return);

        self::assertArrayHasKey('oauth', $manager->getConnections());
    }

    private static function getManager(array $config): GitHubManager
    {
        $repo = Mockery::mock(Repository::class);
        $factory = Mockery::mock(GitHubFactory::class);

        $manager = new GitHubManager($repo, $factory);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('github.connections')->andReturn(['main' => $config]);

        $config['name'] = 'main';

        $manager->getFactory()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock(Client::class));

        return $manager;
    }

    private static function getManagerWithCache(array $config, array $cache): GitHubManager
    {
        $repo = Mockery::mock(Repository::class);
        $factory = Mockery::mock(GitHubFactory::class);
        $manager = new GitHubManager($repo, $factory);

        $repo->shouldReceive('get')->once()
            ->with('github.connections')->andReturn(['oauth' => $config]);

        $repo->shouldReceive('get')->once()
            ->with('github.cache')->andReturn(['redis' => $cache]);

        $cache['name'] = 'redis';
        $config['name'] = 'oauth';
        $config['cache'] = $cache;

        $factory->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock(Client::class));

        return $manager;
    }
}
