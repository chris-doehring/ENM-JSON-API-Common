<?php
namespace Enm\JsonApi\Tests\Model\Response;

use Enm\JsonApi\Model\Common\KeyValueCollection;
use Enm\JsonApi\Model\Document\Document;
use Enm\JsonApi\Model\JsonApi;
use Enm\JsonApi\Model\Response\AcceptedResponse;
use Enm\JsonApi\Model\Response\CreatedResponse;
use Enm\JsonApi\Model\Response\DocumentResponse;
use Enm\JsonApi\Model\Response\EmptyResponse;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testAccepted(): void
    {
        $faker = Factory::create();
        $dummyHeaders = new KeyValueCollection([
            $faker->word => $faker->name,
            $faker->word => $faker->address,
        ]);
        $response = new AcceptedResponse($dummyHeaders);
        $this->assertNull($response->document());
        $this->assertEquals(202, $response->status());
        foreach ($dummyHeaders->all() as $key => $value) {
            $this->assertEquals($value, $response->headers()->getOptional($key));
        }
        $this->assertEquals(JsonApi::CONTENT_TYPE, $response->headers()->getRequired('Content-Type'));
    }

    public function testCreated(): void
    {
        $faker = Factory::create();
        $location = $faker->url;
        $dummyHeaders = new KeyValueCollection([
            $faker->word => $faker->name,
            $faker->word => $faker->address,
        ]);
        /** @var Document $document */
        $document = $this->getMockBuilder(Document::class)->disableOriginalConstructor()->getMock();

        $response = new CreatedResponse($location, $dummyHeaders, $document);
        $this->assertEquals($document, $response->document());
        $this->assertEquals(201, $response->status());
        foreach ($dummyHeaders->all() as $key => $value) {
            $this->assertEquals($value, $response->headers()->getOptional($key));
        }
        $this->assertEquals(JsonApi::CONTENT_TYPE, $response->headers()->getRequired('Content-Type'));
        $this->assertEquals($location, $response->headers()->getRequired('Location'));
    }

    public function testDocument(): void
    {
        $faker = Factory::create();
        $status = $faker->numberBetween();
        $dummyHeaders = new KeyValueCollection([
            $faker->word => $faker->name,
            $faker->word => $faker->address,
        ]);
        /** @var Document $document */
        $document = $this->getMockBuilder(Document::class)->disableOriginalConstructor()->getMock();

        $response = new DocumentResponse($document, $dummyHeaders, $status);
        $this->assertEquals($document, $response->document());
        $this->assertEquals($status, $response->status());
        foreach ($dummyHeaders->all() as $key => $value) {
            $this->assertEquals($value, $response->headers()->getOptional($key));
        }
        $this->assertEquals(JsonApi::CONTENT_TYPE, $response->headers()->getRequired('Content-Type'));
    }

    public function testEmpty(): void
    {
        $faker = Factory::create();
        $dummyHeaders = new KeyValueCollection([
            $faker->word => $faker->name,
            $faker->word => $faker->address,
        ]);

        $response = new EmptyResponse($dummyHeaders);
        $this->assertEquals(204, $response->status());
        $this->assertNull($response->document());
        foreach ($dummyHeaders->all() as $key => $value) {
            $this->assertEquals($value, $response->headers()->getOptional($key));
        }
        $this->assertEquals(JsonApi::CONTENT_TYPE, $response->headers()->getRequired('Content-Type'));
    }
}