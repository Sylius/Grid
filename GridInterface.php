<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Component\Grid;

use Sylius\Component\Grid\Config\Builder\GridBuilderInterface;

interface GridInterface
{
    public static function getName(): string;

    public static function getResourceClass(): string;

    public function toArray(): array;

    public function buildGrid(GridBuilderInterface $gridBuilder): void;
}
