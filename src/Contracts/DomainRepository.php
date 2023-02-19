<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Contracts;

use GuzzleHttp\Exception\GuzzleException;
use SelectelDnsSdk\Dtos\Domain;

interface DomainRepository
{
    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function all(): \Generator;

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function findByName(string $name): Domain|null;

    /**
     * @param int $id
     * @return Domain|null
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function find(int $id): Domain|null;

    /**
     * @throws GuzzleException
     */
    public function delete(Domain|int $id): bool;

    public function add(string $name, string $bindZone = ''): Domain;
}
