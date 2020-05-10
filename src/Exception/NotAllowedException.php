<?php
declare(strict_types=1);

namespace Enm\JsonApi\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class NotAllowedException extends JsonApiException
{
    public function getHttpStatus(): int
    {
        return 403;
    }
}
