<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\PhpParser\Node\Expr\BinaryOp;

use BracketSpace\Notification\Dependencies\PhpParser\Node\Expr\BinaryOp;

class Concat extends BinaryOp {
    public function getOperatorSigil(): string {
        return '.';
    }

    public function getType(): string {
        return 'Expr_BinaryOp_Concat';
    }
}
