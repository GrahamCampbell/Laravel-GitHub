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

namespace GrahamCampbell\Tests\GitHub\Facades;

use GrahamCampbell\GitHub\Facades\GitHub;
use GrahamCampbell\GitHub\GitHubManager;
use GrahamCampbell\TestBenchCore\FacadeTrait;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;

/**
 * This is the github facade test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class GitHubTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'github';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected static function getFacadeClass(): string
    {
        return GitHub::class;
    }

    /**
     * Get the facade root.
     *
     * @return string
     */
    protected static function getFacadeRoot(): string
    {
        return GitHubManager::class;
    }
}
