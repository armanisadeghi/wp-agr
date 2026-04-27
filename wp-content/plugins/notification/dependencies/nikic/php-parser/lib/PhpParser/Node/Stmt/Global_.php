<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\PhpParser\Node\Stmt;

use BracketSpace\Notification\Dependencies\PhpParser\Node;

class Global_ extends Node\Stmt {
    /** @var Node\Expr[] Variables */
    public array $vars;

    /**
     * Constructs a global variables list node.
     *
     * @param Node\Expr[] $vars Variables to unset
     * @param array<string, mixed> $attributes Additional attributes
     */
    public function __construct(array $vars, array $attributes = []) {
        $this->attributes = $attributes;
        $this->vars = $vars;
    }

    public function getSubNodeNames(): array {
        return ['vars'];
    }

    public function getType(): string {
        return 'Stmt_Global';
    }
}
