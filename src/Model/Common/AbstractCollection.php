<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Common;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
abstract class AbstractCollection implements CollectionInterface
{
    protected array $collection;

    public function __construct(array $data = [])
    {
        $this->collection = $data;
    }

    public function all(): array
    {
        return $this->collection;
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function count(): int
    {
        return count($this->collection);
    }
}
