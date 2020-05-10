<?php
namespace Enm\JsonApi\Tests\Model\Document;

use Enm\JsonApi\Model\Document\OffsetBasedPaginatedDocument;
use Enm\JsonApi\Model\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;

class OffsetBasedPaginatedDocumentTest extends TestCase
{
    public function testInstance(): void
    {
        $resultCount = rand(12, 5999);
        $defaultLimit = 10;
        $uri = $this->createMock(UriInterface::class);
        $uri->expects(self::once())->method('__toString')->willReturn('/api/example/1');
        $uri->expects(self::atLeastOnce())->method('getQuery')->willReturn('');
        $uri->expects(self::atLeastOnce())->method('withQuery')->willReturn('/api/example/1?test=1');
        $document = new OffsetBasedPaginatedDocument(
            $this->createMock(ResourceInterface::class),
            $uri,
            $resultCount,
            $defaultLimit
        );
        self::assertEquals(1, $document->data()->count());
        self::assertFalse($document->shouldBeHandledAsCollection());
    }
}