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

namespace Sylius\Component\Grid\Provider;

use Sylius\Component\Grid\Configuration\GridConfigurationExtender;
use Sylius\Component\Grid\Configuration\GridConfigurationExtenderInterface;
use Sylius\Component\Grid\Definition\ArrayToDefinitionConverterInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Exception\UndefinedGridException;
use Webmozart\Assert\Assert;

final class ArrayGridProvider implements GridProviderInterface
{
    private ArrayToDefinitionConverterInterface $converter;
    private GridConfigurationExtenderInterface $gridConfigurationExtender;

    /** @var array[] */
    private array $gridConfigurations;

    public function __construct(
        ArrayToDefinitionConverterInterface $converter,
        array $gridConfigurations,
        ?GridConfigurationExtenderInterface $gridConfigurationExtender = null
    ) {
        $this->converter = $converter;
        $this->gridConfigurations = $gridConfigurations;
        $this->gridConfigurationExtender = $gridConfigurationExtender ?? new GridConfigurationExtender();
    }

    public function get(string $code): Grid
    {
        if (!array_key_exists($code, $this->gridConfigurations)) {
            throw new UndefinedGridException($code);
        }

        $gridConfiguration = $this->gridConfigurations[$code];
        $parentGridCode = $gridConfiguration['extends'] ?? null;

        if (null !== $parentGridCode) {
            $parentGridConfiguration = $this->gridConfigurations[$gridConfiguration['extends']] ?? null;

            Assert::notNull($parentGridConfiguration, sprintf('Parent grid with code "%s" does not exists.', $gridConfiguration['extends']));
            $gridConfiguration = $this->gridConfigurationExtender->extends($gridConfiguration, $parentGridConfiguration);
        }

        return $this->converter->convert($code, $gridConfiguration);
    }
}
