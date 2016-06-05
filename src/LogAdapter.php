<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\GitHub;

use Guzzle\Log\AbstractLogAdapter;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * This log adapter class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class LogAdapter extends AbstractLogAdapter
{
    /**
     * The syslog to PSR-3 mappings.
     *
     * @var array
     */
    protected static $mappings = [
        LOG_DEBUG   => LogLevel::DEBUG,
        LOG_INFO    => LogLevel::INFO,
        LOG_WARNING => LogLevel::WARNING,
        LOG_ERR     => LogLevel::ERROR,
        LOG_CRIT    => LogLevel::CRITICAL,
        LOG_ALERT   => LogLevel::ALERT,
    ];

    /**
     * Crearte a new log adapter instance.
     *
     * @param \Psr\Log\LoggerInterface $log
     *
     * @return void
     */
    public function __construct(LoggerInterface $log)
    {
        $this->log = $log;
    }

    /**
     * Log a message at a priority.
     *
     * @param string $message
     * @param int    $priority
     * @param array  $extras
     *
     * @return void
     */
    public function log($message, $priority = LOG_INFO, $extras = [])
    {
        $this->log->log(static::$mappings[$priority], $message);
    }
}
