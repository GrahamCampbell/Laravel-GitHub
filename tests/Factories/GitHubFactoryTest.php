<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\GitHub\Factories;

use GrahamCampbell\GitHub\Factories\GitHubFactory;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;

/**
 * This is the filesystem factory test class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class GitHubFactoryTest extends AbstractTestCase
{
    public function testMakeStandard()
    {
        $factory = $this->getFactory();

        $return = $factory->make(['token'  => 'your-token']);

        $this->assertInstanceOf('GitHub\Client', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMakeWithoutToken()
    {
        $factory = $this->getFactory();

        $factory->make([]);
    }

    protected function getFactory()
    {
        return new GitHubFactory(__DIR__);
    }
}
