<?php

/*
 * This file is part of the broadway/broadway package.
 *
 * (c) Qandidate.com <opensource@qandidate.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Broadway\EventSourcing;

use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use PHPUnit\Framework\TestCase;

class SimpleEventSourcedEntityTest extends TestCase
{
    /**
     * @test
     */
    public function it_knows_of_aggregate_root_without_any_prior_events()
    {
        $aggregateRoot = new MyTestEntityAggregateRoot();
        $aggregateRoot->importantFunction();
        $this->assertEquals(1, count($aggregateRoot->getUncommittedEvents()));
    }
}

class MyTestEntityAggregateRoot extends EventSourcedAggregateRoot
{
    private $entity;

    public function getAggregateRootId(): string
    {
        return 'y0l0';
    }

    public function importantFunction()
    {
        $this->entity = new MyTestEntity($this);
        $this->entity->importantFunction();
    }
      
}

class MyTestEntity extends SimpleEventSourcedEntity
{
    public function importantFunction()
    {
	$this->apply(new AggregateEvent());
    }
}

