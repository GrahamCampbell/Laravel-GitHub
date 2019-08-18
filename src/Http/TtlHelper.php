<?php

declare(strict_types=1);

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\GitHub\Http;

use DateInterval;
use DateTimeImmutable;
use Illuminate\Contracts\Cache\Repository;
use ReflectionClass;

/**
 * This is TTL helper.
 *
 * The purpose of this class is to detect if the Laravel cache repository is
 * working with minutes or seconds, and also to enforce a min and max TTL.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class TtlHelper
{
    /**
     * Computes the correct TTL to use.
     *
     * @param int                    $min
     * @param int                    $max
     * @param null|int|\DateInterval $ttl
     *
     * @return int
     */
    public static function computeTtl(int $min, int $max, $ttl = null)
    {
        if ($ttl instanceof DateInterval) {
            $ttl = self::dateIntervalToSeconds($ttl);
        }

        $ttl = max($min, min($ttl ?: $min, $max));

        return self::isLegacy() ? (int) floor($ttl / 60.0) : $ttl;
    }

    /**
     * Convert a date interval to seconds.
     *
     * @param \DateInterval $ttl
     *
     * @return int
     */
    private static function dateIntervalToSeconds(DateInterval $ttl)
    {
        $reference = new DateTimeImmutable();
        $endTime = $reference->add($ttl);

        return $endTime->getTimestamp() - $reference->getTimestamp();
    }

    /**
     * If the Laravel cache repository is legacy.
     *
     * Legacy cache repositories work in minutes.
     *
     * @return bool
     */
    private static function isLegacy()
    {
        static $legacy;

        if ($legacy === null) {
            $params = (new ReflectionClass(Repository::class))->getMethod('put')->getParameters();
            $legacy = $params[2]->getName() === 'minutes';
        }

        return $legacy;
    }
}
