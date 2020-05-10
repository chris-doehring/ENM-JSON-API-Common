<?php
declare(strict_types=1);

namespace Enm\JsonApi\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class UnsupportedMediaTypeException extends JsonApiException
{
    public function __construct(string $contentType = '')
    {
        parent::__construct('Invalid content type: ' . $contentType);
    }

    public function getHttpStatus(): int
    {
        return 415;
    }
}
