<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\PhpParser\Node\Expr;

use BracketSpace\Notification\Dependencies\PhpParser\Node;

class Throw_ extends Node\Expr {
    /** @var Node\Expr Expression */
    public Node\Expr $expr;

    /**
     * Constructs a throw expression node.
     *
     * @param Node\Expr $expr Expression
     * @param array<string, mixed> $attributes Additional attributes
     */
    public function __construct(Node\Expr $expr, array $attributes = []) {
        $this->attributes = $attributes;
        $this->expr = $expr;
    }

    public function getSubNodeNames(): array {
        return ['expr'];
    }

    public function getType(): string {
        return 'Expr_Throw';
    }
}
