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

namespace GrahamCampbell\GitHub\Facades;

use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Support\Facades\Facade;

/**
 * This is the github facade class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 * @mixin GitHubManager
 */
class GitHub extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'github';
    }
}
