<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Resource\Relationship;

use Enm\JsonApi\Model\Common\KeyValueCollectionInterface;
use Enm\JsonApi\Model\Resource\Link\LinkCollectionInterface;
use Enm\JsonApi\Model\Resource\ResourceCollectionInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface RelationshipInterface
{
    /**
     * Indicates if the contained data should be handled as object collection or single object
     */
    public function shouldBeHandledAsCollection(): bool;

    public function name(): string;

    public function related(): ResourceCollectionInterface;

    public function links(): LinkCollectionInterface;

    public function metaInformation(): KeyValueCollectionInterface;

    /**
     * Creates a new relationship containing all data from the current one.
     * If set, the new relationship will have the given name.
     */
    public function duplicate(string $name = null): RelationshipInterface;
}
