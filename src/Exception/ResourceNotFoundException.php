<?php
declare(strict_types=1);

namespace Enm\JsonApi\Exception;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class ResourceNotFoundException extends JsonApiException
{
    public function __construct(string $type, string $id)
    {
        parent::__construct('Resource "' . $id . '" of type "' . $type . '" not found!');
    }

    public function getHttpStatus(): int
    {
        return 404;
    }
}
