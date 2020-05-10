<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Response;

use Enm\JsonApi\Model\Common\KeyValueCollectionInterface;
use Enm\JsonApi\Model\JsonApi;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
abstract class AbstractResponse implements ResponseInterface
{
    private int $status;
    private KeyValueCollectionInterface $headers;

    public function __construct(int $status, KeyValueCollectionInterface $headers)
    {
        $this->status = $status;
        $this->headers = $headers;
        $this->headers->set('Content-Type', JsonApi::CONTENT_TYPE);
    }

    public function status(): int
    {
        return $this->status;
    }

    public function headers(): KeyValueCollectionInterface
    {
        return $this->headers;
    }
}
