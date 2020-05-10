<?php
declare(strict_types = 1);

namespace Enm\JsonApi\Model\Error;

use Enm\JsonApi\Model\Common\CollectionInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface ErrorCollectionInterface extends CollectionInterface
{
    /**
     * @return ErrorInterface[]
     */
    public function all(): array;

    public function add(ErrorInterface $error): ErrorCollectionInterface;

    public function first(): ?ErrorInterface;
}
