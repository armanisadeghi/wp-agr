<?php
/**
 * @license MIT
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace BracketSpace\Notification\Dependencies\JsonMapper\Cache;

use BracketSpace\Notification\Dependencies\Psr\SimpleCache\CacheInterface;
use BracketSpace\Notification\Dependencies\Symfony\Component\Cache\Adapter\ArrayAdapter;
use BracketSpace\Notification\Dependencies\Symfony\Component\Cache\Psr16Cache;

class ArrayCache extends Psr16Cache implements CacheInterface
{
    public function __construct()
    {
        parent::__construct(new ArrayAdapter());
    }
}
