<?php

/**
 * This file is part of Laravel GitHub by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Tests\GitHub;

use Mockery;
use GrahamCampbell\GitHub\GitHubManager;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;

/**
 * This is the github manager test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-GitHub/blob/master/LICENSE.md> Apache 2.0
 */
class GitHubManagerTest extends AbstractTestBenchTestCase
{
    public function testCreateConnection()
    {
        $config = array('token' => 'your-token');

        $manager = $this->getManager($config);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('graham-campbell/github::default')->andReturn('main');

        $this->assertEquals($manager->getConnections(), array());

        $return = $manager->connection();

        $this->assertInstanceOf('GitHub\Client', $return);

        $this->assertArrayHasKey('main', $manager->getConnections());
    }

    protected function getManager(array $config)
    {
        $repo = Mockery::mock('Illuminate\Config\Repository');
        $factory = Mockery::mock('GrahamCampbell\GitHub\Factories\GitHubFactory');

        $manager = new GitHubManager($repo, $factory);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('graham-campbell/github::connections')->andReturn(array('main' => $config));

        $config['name'] = 'main';

        $manager->getFactory()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock('GitHub\Client'));

        return $manager;
    }
}
