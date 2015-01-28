<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\GitHub;

use GrahamCampbell\GitHub\GitHubManager;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use Mockery;

/**
 * This is the github manager test class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class GitHubManagerTest extends AbstractTestBenchTestCase
{
    public function testCreateConnection()
    {
        $config = ['token' => 'your-token'];

        $manager = $this->getManager($config);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('github.default')->andReturn('main');

        $this->assertSame([], $manager->getConnections());

        $return = $manager->connection();

        $this->assertInstanceOf('GitHub\Client', $return);

        $this->assertArrayHasKey('main', $manager->getConnections());
    }

    protected function getManager(array $config)
    {
        $repo = Mockery::mock('Illuminate\Contracts\Config\Repository');
        $factory = Mockery::mock('GrahamCampbell\GitHub\Factories\GitHubFactory');

        $manager = new GitHubManager($repo, $factory);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('github.connections')->andReturn(['main' => $config]);

        $config['name'] = 'main';

        $manager->getFactory()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock('GitHub\Client'));

        return $manager;
    }
}
