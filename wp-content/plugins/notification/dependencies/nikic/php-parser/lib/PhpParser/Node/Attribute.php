<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\PhpParser\Node;

use BracketSpace\Notification\Dependencies\PhpParser\Node;
use BracketSpace\Notification\Dependencies\PhpParser\NodeAbstract;

class Attribute extends NodeAbstract {
    /** @var Name Attribute name */
    public Name $name;

    /** @var list<Arg> Attribute arguments */
    public array $args;

    /**
     * @param Node\Name $name Attribute name
     * @param list<Arg> $args Attribute arguments
     * @param array<string, mixed> $attributes Additional node attributes
     */
    public function __construct(Name $name, array $args = [], array $attributes = []) {
        $this->attributes = $attributes;
        $this->name = $name;
        $this->args = $args;
    }

    public function getSubNodeNames(): array {
        return ['name', 'args'];
    }

    public function getType(): string {
        return 'Attribute';
    }
}
