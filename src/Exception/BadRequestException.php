<?php
declare(strict_types=1);

namespace Enm\JsonApi\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class BadRequestException extends JsonApiException
{
    public function __construct(string $message = '')
    {
        if ($message === '') {
            $message = 'Invalid Request!';
        }
        parent::__construct($message);
    }

    public function getHttpStatus(): int
    {
        return 400;
    }
}
