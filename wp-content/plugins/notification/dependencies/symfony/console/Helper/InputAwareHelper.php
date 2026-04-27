<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace BracketSpace\Notification\Dependencies\Symfony\Component\Console\Helper;

use BracketSpace\Notification\Dependencies\Symfony\Component\Console\Input\InputAwareInterface;
use BracketSpace\Notification\Dependencies\Symfony\Component\Console\Input\InputInterface;

/**
 * An implementation of InputAwareInterface for Helpers.
 *
 * @author Wouter J <waldio.webdesign@gmail.com>
 */
abstract class InputAwareHelper extends Helper implements InputAwareInterface
{
    protected $input;

    /**
     * {@inheritdoc}
     */
    public function setInput(InputInterface $input)
    {
        $this->input = $input;
    }
}
