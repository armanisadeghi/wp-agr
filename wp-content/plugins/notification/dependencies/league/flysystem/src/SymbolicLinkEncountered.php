<?php
/**
 * @license MIT
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\League\Flysystem;

use RuntimeException;

final class SymbolicLinkEncountered extends RuntimeException implements FilesystemException
{
    /**
     * @var string
     */
    private $location;

    public function location(): string
    {
        return $this->location;
    }

    public static function atLocation(string $pathName): SymbolicLinkEncountered
    {
        $e = new static("Unsupported symbolic link encountered at location $pathName");
        $e->location = $pathName;

        return $e;
    }
}
