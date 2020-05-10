<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Resource;

use Enm\JsonApi\Model\Common\KeyValueCollection;
use Enm\JsonApi\Model\Common\KeyValueCollectionInterface;
use Enm\JsonApi\Model\Resource\Extension\RelatedMetaInformationInterface;
use Enm\JsonApi\Model\Resource\Extension\RelatedMetaInformationTrait;
use Enm\JsonApi\Model\Resource\Link\LinkCollection;
use Enm\JsonApi\Model\Resource\Link\LinkCollectionInterface;
use Enm\JsonApi\Model\Resource\Relationship\RelationshipCollection;
use Enm\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class JsonResource implements ResourceInterface, RelatedMetaInformationInterface
{
    use RelatedMetaInformationTrait;

    protected string $type;
    protected ?string $id;
    protected KeyValueCollection $attributeCollection;
    protected RelationshipCollection $relationshipCollection;
    protected LinkCollection $linkCollection;
    protected KeyValueCollection $metaCollection;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(string $type, ?string $id = null, array $attributes = [])
    {
        if ($type === '') {
            throw new \InvalidArgumentException('Invalid resource type!');
        }
        $this->type = $type;
        $this->id = $id;

        $this->attributeCollection = new KeyValueCollection($attributes);
        $this->relationshipCollection = new RelationshipCollection();
        $this->linkCollection = new LinkCollection();
        $this->metaCollection = new KeyValueCollection();
    }

    public function type(): string
    {
        return $this->type;
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function attributes(): KeyValueCollectionInterface
    {
        return $this->attributeCollection;
    }

    public function relationships(): RelationshipCollectionInterface
    {
        return $this->relationshipCollection;
    }

    public function links(): LinkCollectionInterface
    {
        return $this->linkCollection;
    }

    public function metaInformation(): KeyValueCollectionInterface
    {
        return $this->metaCollection;
    }

    /**
     * Creates a new resource containing all data from the current one.
     * If set, the new request will have the given id.
     *
     * @throws \InvalidArgumentException
     */
    public function duplicate(string $id = null): ResourceInterface
    {
        $resource = new self($this->type(), $id ?? $this->id(), $this->attributes()->all());

        $resource->metaInformation()->mergeCollection($this->metaInformation());

        foreach ($this->relationships()->all() as $relationship) {
            $resource->relationships()->set($relationship->duplicate());
        }

        foreach ($this->links()->all() as $link) {
            $resource->links()->set($link->duplicate());
        }

        return $resource;
    }
}
