<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\PhpParser\Lexer\TokenEmulator;

use BracketSpace\Notification\Dependencies\PhpParser\PhpVersion;
use BracketSpace\Notification\Dependencies\PhpParser\Token;

final class AttributeEmulator extends TokenEmulator {
    public function getPhpVersion(): PhpVersion {
        return PhpVersion::fromComponents(8, 0);
    }

    public function isEmulationNeeded(string $code): bool {
        return strpos($code, '#[') !== false;
    }

    public function emulate(string $code, array $tokens): array {
        // We need to manually iterate and manage a count because we'll change
        // the tokens array on the way.
        for ($i = 0, $c = count($tokens); $i < $c; ++$i) {
            $token = $tokens[$i];
            if ($token->text === '#' && isset($tokens[$i + 1]) && $tokens[$i + 1]->text === '[') {
                array_splice($tokens, $i, 2, [
                    new Token(\T_ATTRIBUTE, '#[', $token->line, $token->pos),
                ]);
                $c--;
                continue;
            }
        }

        return $tokens;
    }

    public function reverseEmulate(string $code, array $tokens): array {
        // TODO
        return $tokens;
    }

    public function preprocessCode(string $code, array &$patches): string {
        $pos = 0;
        while (false !== $pos = strpos($code, '#[', $pos)) {
            // Replace #[ with %[
            $code[$pos] = '%';
            $patches[] = [$pos, 'replace', '#'];
            $pos += 2;
        }
        return $code;
    }
}
