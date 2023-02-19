<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Repositories\Traits;

use Psr\Http\Message\ResponseInterface;

trait ResponseParser
{
    /**
     * @throws \JsonException
     */
    protected function parseResponse(ResponseInterface $response): array
    {
        return \json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
