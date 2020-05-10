<?php
declare(strict_types=1);

namespace Enm\JsonApi\Tests\Model\Resource;

use Enm\JsonApi\Model\Resource\ImmutableResourceCollection;
use Enm\JsonApi\Model\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class ImmutableResourceCollectionTest extends TestCase
{
    public function testSet(): void
    {
        $this->expectException(\LogicException::class);
        $collection = new ImmutableResourceCollection();
        /** @var ResourceInterface $resource */
        $resource = $this->createMock(ResourceInterface::class);
        $collection->set($resource);
    }

    public function testRemove(): void
    {
        $this->expectException(\LogicException::class);
        $collection = new ImmutableResourceCollection();
        $collection->remove('test', '1');
    }

    public function testRemoveElement(): void
    {
        $this->expectException(\LogicException::class);
        $collection = new ImmutableResourceCollection();
        /** @var ResourceInterface $resource */
        $resource = $this->createMock(ResourceInterface::class);
        $collection->removeElement($resource);
    }
}
