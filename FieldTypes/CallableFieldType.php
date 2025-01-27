<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Component\Grid\FieldTypes;

use Sylius\Component\Grid\DataExtractor\DataExtractorInterface;
use Sylius\Component\Grid\Definition\Field;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CallableFieldType implements FieldTypeInterface
{
    public function __construct(private DataExtractorInterface $dataExtractor)
    {
    }

    public function render(Field $field, $data, array $options): string
    {
        $value = $this->dataExtractor->get($field, $data);
        $value = call_user_func($options['callable'], $value);

        try {
            $value = (string) $value;
        } catch (\Throwable) {
            throw new \RuntimeException(\sprintf('The callback for field "%s" returned a value that could not be converted to string.', $field->getName()));
        }

        if ($options['htmlspecialchars']) {
            $value = htmlspecialchars($value);
        }

        return $value;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('callable');
        $resolver->setAllowedTypes('callable', 'callable');

        $resolver->setDefault('htmlspecialchars', true);
        $resolver->setAllowedTypes('htmlspecialchars', 'bool');
    }
}
