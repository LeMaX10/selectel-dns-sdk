<?php
declare(strict_types = 1);

namespace SelectelDnsSdk;

use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SelectelDnsSdk\Contracts\Client as ClientContract;
use SelectelDnsSdk\Repositories\Traits\ResponseParser;

/**
 * @mixin \GuzzleHttp\Client
 */
final class Client implements ClientContract
{
    use ResponseParser;

    protected const URL = 'https://api.selectel.ru/domains/v1/';

    /**
     * @var \GuzzleHttp\Client
     */
    private \GuzzleHttp\Client $client;

    /**
     * @param string $token
     */
    public function __construct(
        private readonly string $token
    ) {
        $this->instance = new \GuzzleHttp\Client([
            'base_uri' => self::URL,
            RequestOptions::HEADERS => [
                'X-Token' => $this->token,
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->instance->$method(...$args);
    }

    /**
     * @inheritdoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->instance->sendRequest($request);
    }
}
