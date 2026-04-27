<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\PhpParser\Lexer\TokenEmulator;

use BracketSpace\Notification\Dependencies\PhpParser\PhpVersion;
use BracketSpace\Notification\Dependencies\PhpParser\Token;

/** @internal */
abstract class TokenEmulator {
    abstract public function getPhpVersion(): PhpVersion;

    abstract public function isEmulationNeeded(string $code): bool;

    /**
     * @param Token[] $tokens Original tokens
     * @return Token[] Modified Tokens
     */
    abstract public function emulate(string $code, array $tokens): array;

    /**
     * @param Token[] $tokens Original tokens
     * @return Token[] Modified Tokens
     */
    abstract public function reverseEmulate(string $code, array $tokens): array;

    /** @param array{int, string, string}[] $patches */
    public function preprocessCode(string $code, array &$patches): string {
        return $code;
    }
}
