<?php
declare(strict_types = 1);

namespace Enm\JsonApi\Model\Common;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface CollectionInterface extends \Countable
{
    public function all(): array;

    public function isEmpty(): bool;

    public function count(): int;
}
