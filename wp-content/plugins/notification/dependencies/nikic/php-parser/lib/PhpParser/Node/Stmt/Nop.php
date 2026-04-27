<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\PhpParser\Node\Stmt;

use BracketSpace\Notification\Dependencies\PhpParser\Node;

/** Nop/empty statement (;). */
class Nop extends Node\Stmt {
    public function getSubNodeNames(): array {
        return [];
    }

    public function getType(): string {
        return 'Stmt_Nop';
    }
}
