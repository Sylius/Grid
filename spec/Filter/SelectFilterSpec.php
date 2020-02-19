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

namespace spec\Sylius\Component\Grid\Filter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Data\ExpressionBuilderInterface;
use Sylius\Component\Grid\Filtering\FilterInterface;

final class SelectFilterSpec extends ObjectBehavior
{
    function it_implements_a_filter_interface(): void
    {
        $this->shouldImplement(FilterInterface::class);
    }

    function it_filters_by_id(
        DataSourceInterface $dataSource,
        ExpressionBuilderInterface $expressionBuilder
    ): void {
        $dataSource->getExpressionBuilder()->willReturn($expressionBuilder);

        $expressionBuilder->equals('select', '7')->willReturn('EXPR');

        $dataSource->restrict('EXPR')->shouldBeCalled();

        $this->apply($dataSource, 'select', '7', []);
    }

    function it_filters_with_multiple_ids(
        DataSourceInterface $dataSource,
        ExpressionBuilderInterface $expressionBuilder
    ): void {
        $dataSource->getExpressionBuilder()->willReturn($expressionBuilder);

        $expressionBuilder->in('select', ['4', '2'])->willReturn('EXPR');

        $dataSource->restrict('EXPR')->shouldBeCalled();

        $this->apply($dataSource, 'select', ['4', '2'], []);
    }

    function it_does_not_filters_when_data_id_is_not_defined(
        DataSourceInterface $dataSource,
        ExpressionBuilderInterface $expressionBuilder
    ): void {
        $dataSource->getExpressionBuilder()->willReturn($expressionBuilder);

        $expressionBuilder->equals('select', Argument::any())->shouldNotBeCalled();
        $dataSource->restrict(Argument::any())->shouldNotBeCalled();

        $this->apply($dataSource, 'select', '', []);
    }
}
