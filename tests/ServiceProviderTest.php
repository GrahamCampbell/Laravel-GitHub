<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\GitHub;

use GrahamCampbell\TestBench\Traits\ServiceProviderTestCaseTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTestCaseTrait;

    public function testGitHubFactoryIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\GitHub\Factories\GitHubFactory');
    }

    public function testGitHubManagerIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\GitHub\GitHubManager');
    }
}
