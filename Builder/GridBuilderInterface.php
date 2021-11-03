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

namespace Sylius\Component\Grid\Builder;

use Sylius\Component\Grid\Definition\Grid;

interface GridBuilderInterface
{
    public static function create(string $code, string $resourceClass): self;

    public function setDriver(string $driver): self;

    /**
     * @param string|array $method
     */
    public function setRepositoryMethod($method, array $arguments = []): self;

    public function addField(FieldInterface $field): self;

    public function removeField(string $name): self;

    public function orderBy(string $name, string $direction): self;

    public function addOrderBy(string $name, string $direction): self;

    public function setLimits(array $limits): self;

    public function addFilter(FilterInterface $filter): self;

    public function removeFilter(string $name): self;

    public function addActionGroup(string $name): self;

    public function addMainAction(ActionInterface $action): self;

    public function addItemAction(ActionInterface $action): self;

    public function addCreateAction(array $options = []): self;

    public function addUpdateAction(array $options = []): self;

    public function addDeleteAction(array $options = []): self;

    public function getDefinition(): Grid;
}
