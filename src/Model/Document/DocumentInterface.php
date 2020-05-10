<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Document;

use Enm\JsonApi\Model\Common\KeyValueCollectionInterface;
use Enm\JsonApi\Model\Error\ErrorCollectionInterface;
use Enm\JsonApi\Model\Resource\Link\LinkCollectionInterface;
use Enm\JsonApi\Model\Resource\ResourceCollectionInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface DocumentInterface
{
    /**
     * Indicates if the contained data should be handled as object collection or single object
     */
    public function shouldBeHandledAsCollection(): bool;

    public function links(): LinkCollectionInterface;

    public function data(): ResourceCollectionInterface;

    public function included(): ResourceCollectionInterface;

    public function metaInformation(): KeyValueCollectionInterface;

    public function errors(): ErrorCollectionInterface;
}
