<?php
declare(strict_types=1);

namespace Enm\JsonApi\Exception;

use Enm\JsonApi\Model\Error\ErrorCollectionInterface;
use Throwable;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class HttpException extends JsonApiException
{
    /**
     * @var int
     */
    private $statusCode;

    public function __construct(
        int $statusCode,
        string $message = '',
        $code = 0,
        Throwable $previous = null,
        ErrorCollectionInterface $errors = null
    ) {
        $this->statusCode = $statusCode;
        parent::__construct($message, $code, $previous, $errors);
    }

    /**
     * @return int
     */
    public function getHttpStatus(): int
    {
        return $this->statusCode;
    }
}
