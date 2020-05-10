<?php
namespace Enm\JsonApi\Tests\Model\Document;

use Enm\JsonApi\Model\Document\OffsetBasedPaginatedDocument;
use Enm\JsonApi\Model\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;

class OffsetBasedPaginatedDocumentTest extends TestCase
{
    /** @dataProvider provideTestScenarios */
    public function testInstance(int $offset): void
    {
        $resultCount = rand(22, 5999);
        $defaultLimit = 10;
        $uri = $this->createMock(UriInterface::class);
        $uri->expects(self::once())->method('__toString')->willReturn('/api/example/1');
        $uri->expects(self::atLeastOnce())->method('getQuery')->willReturn('/api/example?page[offset]='.$offset.'&page[limit]=10');
        $uri->expects(self::atLeastOnce())->method('withQuery')->willReturn('/api/example/1?test=1');
        $document = new OffsetBasedPaginatedDocument(
            $this->createMock(ResourceInterface::class),
            $uri,
            $resultCount,
            $defaultLimit
        );
        self::assertEquals(true, $document->links()->has('self'));
        self::assertEquals(true, $document->links()->has('next'));
        self::assertEquals(true, $document->links()->has('last'));
    }

    public function provideTestScenarios(): array
    {
        return [
            [0],
            [10],
            [20],
        ];
    }
}