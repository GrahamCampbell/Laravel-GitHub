<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\GitHub\Factories;

use GrahamCampbell\GitHub\Authenticators\AuthenticatorFactory;
use GrahamCampbell\GitHub\Factories\GitHubFactory;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;

/**
 * This is the github factory test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class GitHubFactoryTest extends AbstractTestCase
{
    public function testMakeStandard()
    {
        $factory = $this->getFactory();

        $return = $factory->make(['token' => 'your-token', 'method' => 'token']);

        $this->assertInstanceOf('Github\Client', $return);
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
