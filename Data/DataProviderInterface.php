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

namespace Sylius\Component\Grid\Data;

use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;

interface DataProviderInterface
{
    public function getData(Grid $grid, Parameters $parameters);
}
