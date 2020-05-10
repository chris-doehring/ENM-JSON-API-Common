<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Response;

use Enm\JsonApi\Model\Common\KeyValueCollectionInterface;
use Enm\JsonApi\Model\Document\DocumentInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
interface ResponseInterface
{
    public function status(): int;
    public function headers(): KeyValueCollectionInterface;
    public function document(): ?DocumentInterface;
}
