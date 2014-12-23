<?php

/*
 * This file is part of Laravel GitHub by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at http://bit.ly/UWsjkb.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Tests\GitHub\Factories;

use GrahamCampbell\GitHub\Factories\GitHubFactory;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;

/**
 * This is the filesystem factory test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-GitHub/blob/master/LICENSE.md> Apache 2.0
 */
class GitHubFactoryTest extends AbstractTestCase
{
    public function testMakeStandard()
    {
        $factory = $this->getFactory();

        $return = $factory->make(array('token'  => 'your-token'));

        $this->assertInstanceOf('GitHub\Client', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMakeWithoutToken()
    {
        $factory = $this->getFactory();

        $factory->make(array());
    }

    protected function getFactory()
    {
        return new GitHubFactory(__DIR__);
    }
}
