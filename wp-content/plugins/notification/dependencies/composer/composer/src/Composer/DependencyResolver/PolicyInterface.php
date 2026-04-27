<?php
/**
 * @license MIT
 *
 * Modified by bracketspace on 05-September-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

/*
 * This file is part of Composer.
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BracketSpace\Notification\Dependencies\Composer\DependencyResolver;

use BracketSpace\Notification\Dependencies\Composer\Package\PackageInterface;
use BracketSpace\Notification\Dependencies\Composer\Semver\Constraint\Constraint;

/**
 * @author Nils Adermann <naderman@naderman.de>
 */
interface PolicyInterface
{
    /**
     * @phpstan-param Constraint::STR_OP_* $operator
     */
    public function versionCompare(PackageInterface $a, PackageInterface $b, string $operator): bool;

    /**
     * @param  non-empty-list<int>   $literals
     * @return non-empty-list<int>
     */
    public function selectPreferredPackages(Pool $pool, array $literals, ?string $requiredPackage = null): array;
}
