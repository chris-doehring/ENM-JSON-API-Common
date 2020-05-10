<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Resource;

use Enm\JsonApi\Model\Common\KeyValueCollectionInterface;
use Enm\JsonApi\Model\Resource\Link\LinkCollectionInterface;
use Enm\JsonApi\Model\Resource\Relationship\RelationshipCollectionInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface ResourceInterface
{
    public function type(): string;

    public function id(): ?string;

    public function attributes(): KeyValueCollectionInterface;

    public function relationships(): RelationshipCollectionInterface;

    public function links(): LinkCollectionInterface;

    public function metaInformation(): KeyValueCollectionInterface;

    /**
     * Creates a new resource containing all data from the current one.
     * If set, the new resource will have the given id.
     */
    public function duplicate(string $id = null): ResourceInterface;
}
