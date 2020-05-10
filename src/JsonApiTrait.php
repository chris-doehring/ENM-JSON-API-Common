<?php
declare(strict_types=1);

namespace Enm\JsonApi;

use Enm\JsonApi\Model\Document\Document;
use Enm\JsonApi\Model\Document\DocumentInterface;
use Enm\JsonApi\Model\Resource\JsonResource;
use Enm\JsonApi\Model\Resource\Relationship\Relationship;
use Enm\JsonApi\Model\Resource\Relationship\RelationshipInterface;
use Enm\JsonApi\Model\Resource\ResourceInterface;
use InvalidArgumentException;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
trait JsonApiTrait
{
    /**
     * @throws InvalidArgumentException
     */
    protected function resource(string $type, ?string $id = null, array $attributes = []): ResourceInterface
    {
        return new JsonResource($type, $id, $attributes);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function singleResourceDocument(ResourceInterface $resource = null): DocumentInterface
    {
        return new Document($resource);
    }

    /**
     * @param ResourceInterface[] $resource
     * @return DocumentInterface
     * @throws InvalidArgumentException
     */
    protected function multiResourceDocument(array $resource = []): DocumentInterface
    {
        return new Document($resource);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function toOneRelationship(string $name, ResourceInterface $related = null): RelationshipInterface
    {
        return new Relationship($name, $related);
    }

    /**
     * @param string $name
     * @param ResourceInterface[] $related
     * @return RelationshipInterface
     * @throws InvalidArgumentException
     */
    protected function toManyRelationship(string $name, array $related = []): RelationshipInterface
    {
        return new Relationship($name, $related);
    }
}
