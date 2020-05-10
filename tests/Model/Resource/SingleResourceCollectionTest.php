<?php
declare(strict_types=1);

namespace Enm\JsonApi\Tests\Model\Resource;

use Enm\JsonApi\Model\Resource\ResourceInterface;
use Enm\JsonApi\Model\Resource\SingleResourceCollection;
use PHPUnit\Framework\TestCase;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class SingleResourceCollectionTest extends TestCase
{

    public function testSet(): void
    {
        $collection = new SingleResourceCollection();

        self::assertCount(0, $collection);

        /** @var ResourceInterface $resource */
        $resource = $this->createMock(ResourceInterface::class);
        $collection->set($resource);

        self::assertCount(1, $collection);
    }

    public function testConstructMultiple(): void
    {
        $this->expectException(\LogicException::class);
        new SingleResourceCollection(
            [
                $this->createMock(ResourceInterface::class),
                $this->createMock(ResourceInterface::class)
            ]
        );
    }

    public function testSetMultiple(): void
    {
        $this->expectException(\LogicException::class);
        $collection = new SingleResourceCollection();
        /** @var ResourceInterface $resource */
        $resource = $this->createMock(ResourceInterface::class);
        $collection->set($resource);
        $collection->set($resource);
    }
}
