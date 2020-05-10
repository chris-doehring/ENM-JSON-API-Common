<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Common;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface KeyValueCollectionInterface extends CollectionInterface
{
    public function has(string $key): bool;

    /**
     * @throws \InvalidArgumentException if key does not exists
     */
    public function getRequired(string $key);

    public function getOptional(string $key, $defaultValue = null);

    /**
     * Creates a (sub) collection for an array value from the current collection.
     */
    public function createSubCollection(string $key, bool $required = true): KeyValueCollectionInterface;

    public function merge(array $data, bool $overwrite = true): KeyValueCollectionInterface;

    public function mergeCollection(
        KeyValueCollectionInterface $collection,
        bool $overwrite = true
    ): KeyValueCollectionInterface;

    public function set(string $key, $value): KeyValueCollectionInterface;

    public function remove(string $key): KeyValueCollectionInterface;
}
