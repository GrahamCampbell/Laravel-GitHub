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
use GrahamCampbell\GitHub\Auth\AuthenticatorFactory;
use GrahamCampbell\GitHub\Cache\ConnectionFactory;
use GrahamCampbell\GitHub\GitHubFactory;
use GrahamCampbell\GitHub\GitHubManager;
use GrahamCampbell\GitHub\HttpClient\BuilderFactory;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testHttpClientFactoryIsInjectable(): void
    {
        $this->assertIsInjectable(BuilderFactory::class);
    }

    public function testAuthFactoryIsInjectable(): void
    {
        $this->assertIsInjectable(AuthenticatorFactory::class);
    }

    public function testCacheFactoryIsInjectable(): void
    {
        $this->assertIsInjectable(ConnectionFactory::class);
    }

    public function testGitHubFactoryIsInjectable(): void
    {
        $this->assertIsInjectable(GitHubFactory::class);
    }

    public function testGitHubManagerIsInjectable(): void
    {
        $this->assertIsInjectable(GitHubManager::class);
    }

    public function testBindings(): void
    {
        $this->assertIsInjectable(Client::class);

        $original = $this->app['github.connection'];
        $this->app['github']->reconnect();
        $new = $this->app['github.connection'];

        self::assertNotSame($original, $new);
        self::assertEquals($original, $new);
    }
}
