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
use Github\HttpClient\CachedHttpClient;
use Github\HttpClient\HttpClient;
use GrahamCampbell\GitHub\Authenticators\AuthenticatorFactory;
use GrahamCampbell\GitHub\GitHubFactory;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use Mockery;
use Psr\Log\LoggerInterface;

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
        $this->markTestIncomplete('Need to test no caching or backoff.');
    }

    public function testMakeStandardExplicitCache()
    {
        $factory = $this->getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'cache' => true]);

        $this->assertInstanceOf(Client::class, $client);
        $this->markTestIncomplete('Need to test caching.');
    }

    public function testMakeStandardNoCacheOrBackoff()
    {
        $factory = $this->getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'cache' => false, 'backoff' => false]);

        $this->assertInstanceOf(Client::class, $client);
        $this->markTestIncomplete('Need to test caching or backoff.');
    }

    public function testMakeStandardExplicitBacoff()
    {
        $factory = $this->getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'backoff' => true]);

        $this->assertInstanceOf(Client::class, $client);
        $this->markTestIncomplete('Need to test backoff.');
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
        return new GitHubFactory(new AuthenticatorFactory());
    }
}
