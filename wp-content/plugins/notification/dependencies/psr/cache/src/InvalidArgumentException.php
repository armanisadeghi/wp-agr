<?php
/**
 * @license MIT
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace BracketSpace\Notification\Dependencies\Psr\Cache;

/**
 * Exception interface for invalid cache arguments.
 *
 * Any time an invalid argument is passed into a method it must throw an
 * exception class which implements BracketSpace\Notification\Dependencies\Psr\Cache\InvalidArgumentException.
 */
interface InvalidArgumentException extends CacheException
{
}
