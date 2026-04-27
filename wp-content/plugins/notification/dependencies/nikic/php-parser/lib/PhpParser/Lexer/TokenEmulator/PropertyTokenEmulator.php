<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\PhpParser\Lexer\TokenEmulator;

use BracketSpace\Notification\Dependencies\PhpParser\PhpVersion;

final class PropertyTokenEmulator extends KeywordEmulator {
    public function getPhpVersion(): PhpVersion {
        return PhpVersion::fromComponents(8, 4);
    }

    public function getKeywordString(): string {
        return '__property__';
    }

    public function getKeywordToken(): int {
        return \T_PROPERTY_C;
    }
}
