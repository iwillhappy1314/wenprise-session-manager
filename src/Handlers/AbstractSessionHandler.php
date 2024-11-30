<?php
/**
 * Generic WordPress Session Handler
 *
 * Abstract class to define common routines to various session handler implementations.
 *
 * @package WP Session Manager
 * @subpackage Handlers
 * @since 3.0
 */

namespace Wenprise\SessionManager\Handlers;

use Wenprise\SessionManager\Interfaces\HandlerInterface;

/**
 * Use an associative array to store session data so we can cut down on
 * round trips to an external storage mechanism (or just leverage an in-
 * memory cache for read performance).
 */
abstract class AbstractSessionHandler implements HandlerInterface
{

    /**
     * Sanitize a potential Session key so we aren't fetching broken data
     * from the options table.
     *
     * @param string $key Session key to sanitize.
     *
     * @return string
     */
    protected function sanitize(string $key): string
    {
        return preg_replace('/[^A-Za-z0-9_]/', '', $key);
    }
}
