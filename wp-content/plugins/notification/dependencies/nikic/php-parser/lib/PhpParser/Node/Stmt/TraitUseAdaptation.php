<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\PhpParser\Node\Stmt;

use BracketSpace\Notification\Dependencies\PhpParser\Node;

abstract class TraitUseAdaptation extends Node\Stmt {
    /** @var Node\Name|null Trait name */
    public ?Node\Name $trait;
    /** @var Node\Identifier Method name */
    public Node\Identifier $method;
}
