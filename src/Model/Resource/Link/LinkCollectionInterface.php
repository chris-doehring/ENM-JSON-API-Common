<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Resource\Link;

use Enm\JsonApi\Model\Common\CollectionInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface LinkCollectionInterface extends CollectionInterface
{
    /**
     * @return LinkInterface[]
     */
    public function all(): array;

    public function has(string $name): bool;

    public function get(string $name): LinkInterface;

    public function set(LinkInterface $link): LinkCollectionInterface;

    public function merge(LinkInterface $link, bool $replaceExistingValues = false): LinkCollectionInterface;

    public function remove(string $name): LinkCollectionInterface;

    public function removeElement(LinkInterface $link): LinkCollectionInterface;

    public function createLink(string $name, string $href): LinkCollectionInterface;
}
