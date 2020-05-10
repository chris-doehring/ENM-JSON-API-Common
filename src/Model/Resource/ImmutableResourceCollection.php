<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Resource;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class ImmutableResourceCollection extends ResourceCollection
{
    /**
     * @throws \LogicException
     */
    public function set(ResourceInterface $resource): ResourceCollectionInterface
    {
        throw new \LogicException('Tried to change an immutable collection...');
    }

    /**
     * @throws \LogicException
     */
    public function remove(string $type, string $id): ResourceCollectionInterface
    {
        throw new \LogicException('Tried to change an immutable collection...');
    }

    /**
     * @throws \LogicException
     */
    public function removeElement(ResourceInterface $resource): ResourceCollectionInterface
    {
        throw new \LogicException('Tried to change an immutable collection...');
    }
}
