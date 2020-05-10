<?php
declare(strict_types=1);

namespace Enm\JsonApi\Tests\Model\Request;

use Enm\JsonApi\Exception\BadRequestException;
use Enm\JsonApi\Model\Document\Document;
use Enm\JsonApi\Model\JsonApi;
use Enm\JsonApi\Model\Request\Request;
use Faker\Factory;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class RequestTest extends TestCase
{
    public function testRequest(): void
    {
        $allowedMethods = ['GET', 'POST', 'PATCH', 'DELETE'];
        $method = $allowedMethods[array_rand($allowedMethods)];
        /** @var Document $requestBody */
        $requestBody = $this->getMockBuilder(Document::class)->disableOriginalConstructor()->getMock();
        try {
            $request = new Request(
                $method,
                new Uri('/index.php/api/examples/example-1?include=tests,tests.user&fields[user]=username,birthday&page[offset]=0&page[limit]=10&sort=-createdAt&filter[test]=test'),
                $requestBody,
                'api'
            );
        } catch (\Exception $e) {
            $this->fail($e->getMessage() . ' (' . $e->getFile() . ', ' . $e->getLine() . ')');
            return;
        }

        self::assertEquals($method, $request->method());
        self::assertInstanceOf(UriInterface::class, $request->uri());
        self::assertEquals($requestBody, $request->requestBody());
        self::assertEquals('examples', $request->type());
        self::assertEquals('example-1', $request->id());
        self::assertNull($request->relationship());
        self::assertTrue($request->requestsAttributes());
        self::assertTrue($request->requestsMetaInformation());
        self::assertTrue($request->requestsRelationships());
        self::assertTrue($request->requestsInclude('tests'));
        self::assertTrue($request->requestsInclude('tests.user'));
        self::assertFalse($request->requestsInclude('examples'));
        self::assertTrue($request->requestsField('examples', 'test'));
        self::assertTrue($request->requestsField('user', 'username'));
        self::assertTrue($request->requestsField('user', 'birthday'));
        self::assertFalse($request->requestsField('user', 'password'));
        self::assertEquals('test', $request->filterValue('test'));
        self::assertEquals(['createdAt' => 'desc'], $request->order());
        self::assertEquals('0', $request->paginationValue('offset'));
        self::assertEquals('10', $request->paginationValue('limit'));
        self::assertEquals(JsonApi::CONTENT_TYPE, $request->headers()->getRequired('Content-Type'));

        $request->requestField('user', 'password');
        self::assertTrue($request->requestsField('user', 'password'));

        self::assertFalse($request->hasFilter('newFilter'));
        $request->addFilter('newFilter', 'value');
        self::assertTrue($request->hasFilter('newFilter'));

        self::assertFalse($request->hasPagination('newPagination'));
        $request->addPagination('newPagination', 'value');
        self::assertTrue($request->hasPagination('newPagination'));

        $request->requestInclude('examples');
        self::assertTrue($request->requestsInclude('examples'));
    }

    public function testCreateFromHttpRequest(): void
    {
        $faker = Factory::create();
        /** @var RequestInterface|MockObject $requestInterface */
        $requestInterface = $this->getMockBuilder(RequestInterface::class)->getMock();
        /** @var UriInterface|MockObject $request */
        $uri = $this->getMockBuilder(UriInterface::class)->getMock();
        $uri->expects(self::once())->method('getPath')->willReturn('/index.php/api/example');
        $uri->expects(self::once())->method('getQuery')->willReturn('');
        /** @var Document $requestBody */
        $requestBody = $this->getMockBuilder(Document::class)->disableOriginalConstructor()->getMock();
        $method = 'POST';

        $requestInterface->expects(self::once())->method('getMethod')->willReturn($method);
        $requestInterface->expects(self::once())->method('getUri')->willReturn($uri);
        $headers = [
            'Content-Type' => [JsonApi::CONTENT_TYPE],
            $faker->word => [$faker->userName],
        ];
        $requestInterface->expects(self::once())->method('getHeaders')->willReturn($headers);

        $request = Request::createFromHttpRequest($requestInterface, $requestBody, 'api');
        $this->assertEquals($method, $request->method());
        $this->assertEquals($uri, $request->uri());
        $this->assertEquals($requestBody, $request->requestBody());
    }

    public function testRequestInvalidType(): void
    {
        $this->expectException(BadRequestException::class);
        new Request(
            'GET',
            new Uri('/index.php/api'),
            null,
            'api'
        );
    }

    public function testInvalidHttpMethod(): void
    {
        $this->expectException(BadRequestException::class);
        new Request(
            'no HTTP status',
            new Uri('/index.php/api')
        );
    }

    public function testInvalidRelationshipKeyword(): void
    {
        $this->expectException(BadRequestException::class);
        new Request(
            'GET',
            new Uri('/index.php/api/example/1/noRelationshipKeyword/exampleRelationship'),
            null,
            'api'
        );
    }

    public function testRelationshipDetailRequest(): void
    {
        $request = new Request(
            'GET',
            new Uri('/index.php/api/example/1/relationships/exampleRelationshipDetail'),
            null,
            'api'
        );
        $this->assertEquals('exampleRelationshipDetail', $request->relationship());
    }

    public function testRelationshipRequest(): void
    {
        $request = new Request(
            'GET',
            new Uri('/index.php/api/example/1/exampleRelationship'),
            null,
            'api'
        );
        $this->assertEquals('exampleRelationship', $request->relationship());
    }

    public function testInvalidIncludeDatatype(): void
    {
        $this->expectException(BadRequestException::class);
        new Request(
            'GET',
            new Uri('/index.php/api/examples/example-1?include[]=test'),
            null,
            'api'
        );
    }

    public function testInvalidFieldsDatatype(): void
    {
        $this->expectException(BadRequestException::class);
        new Request(
            'GET',
            new Uri('/index.php/api/examples/example-1?fields=test'),
            null,
            'api'
        );
    }

    public function testNotSupportedFilterString(): void
    {
        $this->expectException(BadRequestException::class);
        new Request(
            'GET',
            new Uri('/index.php/api/examples/example-1?filter=notSupported'),
            null,
            'api'
        );
    }

    public function testJsonAsFilterString(): void
    {
        $faker = Factory::create();
        $filterKey = $faker->word;
        $filter = [
            $filterKey => $faker->name,
        ];
        $request = new Request(
            'GET',
            new Uri('/index.php/api/examples/example-1?filter='.json_encode($filter)),
            null,
            'api'
        );
        $this->assertEquals($filter[$filterKey], $request->filterValue($filterKey));
    }

    public function testInvalidPaginationDatatype(): void
    {
        $this->expectException(BadRequestException::class);
        new Request(
            'GET',
            new Uri('/index.php/api/examples/example-1?page=invalid'),
            null,
            'api'
        );
    }

    public function testInvalidSortingDatatype(): void
    {
        $this->expectException(BadRequestException::class);
        new Request(
            'GET',
            new Uri('/index.php/api/examples/example-1?sort[]=invalid'),
            null,
            'api'
        );
    }
}
