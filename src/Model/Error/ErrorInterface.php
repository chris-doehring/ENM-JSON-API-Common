<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Error;

use Enm\JsonApi\Model\Common\KeyValueCollectionInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface ErrorInterface
{
    public function status(): int;

    public function code(): string;

    public function title(): string;

    public function detail(): string;

    public function metaInformation(): KeyValueCollectionInterface;

    public function source(): KeyValueCollectionInterface;
}
