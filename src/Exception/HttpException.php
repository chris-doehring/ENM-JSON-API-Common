<?php
declare(strict_types=1);

namespace Enm\JsonApi\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class HttpException extends JsonApiException
{
    private int $statusCode;

    public function __construct(int $statusCode, string $message = '', $code = 0, \Throwable $previous = null)
    {
        $this->statusCode = $statusCode;
        parent::__construct($message, $code, $previous);
    }

    public function getHttpStatus(): int
    {
        return $this->statusCode;
    }
}
