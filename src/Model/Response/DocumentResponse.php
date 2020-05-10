<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Response;

use Enm\JsonApi\Model\Common\KeyValueCollection;
use Enm\JsonApi\Model\Common\KeyValueCollectionInterface;
use Enm\JsonApi\Model\Document\DocumentInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class DocumentResponse extends AbstractResponse
{
    private DocumentInterface $document;

    public function __construct(
        DocumentInterface $document,
        ?KeyValueCollectionInterface $headers = null,
        int $status = 200
    ) {
        parent::__construct($status, $headers ?? new KeyValueCollection());
        $this->document = $document;
    }

    public function document(): ?DocumentInterface
    {
        return $this->document;
    }
}
