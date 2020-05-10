<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Response;

use Enm\JsonApi\Model\Common\KeyValueCollection;
use Enm\JsonApi\Model\Common\KeyValueCollectionInterface;
use Enm\JsonApi\Model\Document\DocumentInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class CreatedResponse extends AbstractResponse
{
    private ?DocumentInterface $document;

    public function __construct(
        string $location,
        ?KeyValueCollectionInterface $headers = null,
        ?DocumentInterface $document = null
    ) {
        parent::__construct(201, $headers ?? new KeyValueCollection());
        $this->headers()->set('Location', $location);
        $this->document = $document;
    }

    public function document(): ?DocumentInterface
    {
        return $this->document;
    }
}
