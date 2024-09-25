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

namespace Sylius\Component\Grid\Tests\Unit\Symfony\Session\Filter\Storage;

use PHPUnit\Framework\TestCase;
use Sylius\Component\Grid\Filter\Storage\FilterStorageInterface;
use Sylius\Component\Grid\Symfony\Session\Filter\Storage\SessionFilterStorage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

final class SessionFilterStorageTest extends TestCase
{
    public function testItImplementsFilterStorageInterface(): void
    {
        $this->assertInstanceOf(FilterStorageInterface::class, new SessionFilterStorage(new RequestStack()));
    }

    public function testItSetsFiltersInASession(): void
    {
        $filters = [
            'filter' => 'value',
        ];

        $requestStack = new RequestStack();
        $request = new Request();
        $session = new Session(new MockArraySessionStorage());

        $request->setSession($session);
        $requestStack->push($request);

        $filterStorage = new SessionFilterStorage($requestStack);
        $filterStorage->set($filters);

        $this->assertEquals($filters, $session->get('filters'));
    }

    public function testItReturnsAllFiltersFromASession(): void
    {
        $filters = [
            'filter' => 'value',
        ];

        $requestStack = new RequestStack();
        $request = new Request();
        $session = new Session(new MockArraySessionStorage());

        $session->set('filters', $filters);
        $request->setSession($session);
        $requestStack->push($request);

        $filterStorage = new SessionFilterStorage($requestStack);

        $this->assertEquals($filters, $filterStorage->all());
    }

    public function testItReturnsTrueIfFiltersAreSet(): void
    {
        $filters = [
            'filter' => 'value',
        ];

        $requestStack = new RequestStack();
        $request = new Request();
        $session = new Session(new MockArraySessionStorage());

        $session->set('filters', $filters);
        $request->setSession($session);
        $requestStack->push($request);

        $filterStorage = new SessionFilterStorage($requestStack);

        $this->assertTrue($filterStorage->hasFilters());
    }

    public function testItReturnsFalseIfFiltersAreSet(): void
    {
        $filters = [];

        $requestStack = new RequestStack();
        $request = new Request();
        $session = new Session(new MockArraySessionStorage());

        $session->set('filters', $filters);
        $request->setSession($session);
        $requestStack->push($request);

        $filterStorage = new SessionFilterStorage($requestStack);

        $this->assertFalse($filterStorage->hasFilters());
    }
}
