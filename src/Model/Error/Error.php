<?php
declare(strict_types=1);

namespace Enm\JsonApi\Model\Error;

use Enm\JsonApi\Exception\JsonApiException;
use Enm\JsonApi\Model\Common\KeyValueCollection;
use Enm\JsonApi\Model\Common\KeyValueCollectionInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class Error implements ErrorInterface
{
    private int $status;
    private string $title;
    private string $detail;
    private string $code;
    private KeyValueCollection $metaCollection;
    private KeyValueCollection $source;

    public function __construct(int $status, string $title, string $detail = '', string $code = '')
    {
        $this->status = $status;
        $this->title = $title;
        $this->detail = $detail;
        $this->code = $code;

        $this->metaCollection = new KeyValueCollection();
        $this->source = new KeyValueCollection();
    }

    public static function createFrom(\Throwable $throwable, $debug = false): ErrorInterface
    {
        $status = 500;
        if ($throwable instanceof JsonApiException) {
            $status = $throwable->getHttpStatus();
        }

        $code = '';
        if ($throwable->getCode() !== 0) {
            $code = (string)$throwable->getCode();
        }

        $error = new self(
            $status,
            $throwable->getMessage(),
            ($debug ? $throwable->getTraceAsString() : ''),
            $code
        );

        if ($debug) {
            $error->metaInformation()->set('file', $throwable->getFile());
            $error->metaInformation()->set('line', $throwable->getLine());
        }

        return $error;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function detail(): string
    {
        return $this->detail;
    }

    public function metaInformation(): KeyValueCollectionInterface
    {
        return $this->metaCollection;
    }

    public function source(): KeyValueCollectionInterface
    {
        return $this->source;
    }
}
