<?php

declare(strict_types=1);

namespace Sylius\Component\Grid\Tests\Dummy;

use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class ClassAsParameterGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    private string $authorClass;

    public function __construct(string $authorClass)
    {
        $this->authorClass = $authorClass;
    }

    public static function getName(): string
    {
        return 'app_class_as_parameter';
    }

    public function getResourceClass(): string
    {
        return $this->authorClass;
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
    }
}
