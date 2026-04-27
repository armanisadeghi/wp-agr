<?php
/**
 * @license MIT
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace BracketSpace\Notification\Dependencies\League\Flysystem;

use RuntimeException;
use Throwable;

class UnableToCheckFileExistence extends RuntimeException implements FilesystemOperationFailed
{
    public static function forLocation(string $path, Throwable $exception = null): UnableToCheckFileExistence
    {
        return new UnableToCheckFileExistence("Unable to check file existence for: ${path}", 0, $exception);
    }

    public function operation(): string
    {
        return FilesystemOperationFailed::OPERATION_FILE_EXISTS;
    }
}
