<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\GitHub;

use Github\Client;
use GrahamCampbell\GitHub\Authenticators\AuthenticatorFactory;
use GrahamCampbell\GitHub\GitHubFactory;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;

/**
 * This is the github factory test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubFactoryTest extends AbstractTestBenchTestCase
{
    public function testMakeStandard()
    {
        $factory = $this->getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token']);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(HttpClient::class, $client->getHttpClient());
        $this->assertInstanceOf(CachedHttpClient::class, $client->getHttpClient());
    }

    public function testMakeStandardExplicitCache()
    {
        $factory = $this->getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'cache' => true]);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(HttpClient::class, $client->getHttpClient());
        $this->assertInstanceOf(CachedHttpClient::class, $client->getHttpClient());
    }

    public function testMakeStandardCustomCache()
    {
        $factory = $this->getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'cache' => __DIR__]);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(HttpClient::class, $client->getHttpClient());
        $this->assertInstanceOf(CachedHttpClient::class, $client->getHttpClient());
    }

    public function testMakeStandardNoCache()
    {
        $factory = $this->getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'cache' => false]);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(HttpClient::class, $client->getHttpClient());
        $this->assertNotInstanceOf(CachedHttpClient::class, $client->getHttpClient());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unsupported authentication method [bar].
     */
    public function testMakeInvalidMethod()
    {
        $factory = $this->getFactory();

        $factory->make(['method' => 'bar']);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unsupported authentication method [].
     */
    public function testMakeEmpty()
    {
        $factory = $this->getFactory();

        $factory->make([]);
    }

    protected function getFactory()
    {
        return new GitHubFactory(new AuthenticatorFactory(), __DIR__);
    }
}
