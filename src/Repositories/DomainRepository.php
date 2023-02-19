<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Repositories;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use SelectelDnsSdk\Dtos\Domain;
use SelectelDnsSdk\Dtos\DomainCreate;
use SelectelDnsSdk\Contracts\DomainRepository as DomainRepositoryContract;

/**
 * Class DomainRepository.
 * @package SelectelDns\Repositories
 * @author Vladimir Pyankov, vladimir@pyankov.pro
 */
final class DomainRepository extends Repository implements DomainRepositoryContract
{
    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function all(): \Generator
    {
        $offset = 0;

        getDomains:
        $request = $this->manager
            ->getClient()
            ->get('', [
                RequestOptions::QUERY => [
                    'offset' => $offset,
                ],
            ]);

        foreach($this->parseResponse($request) as $item) {
            yield $this->makeItem($item);
        }

        if ($request->getHeader('X-Total-Count')[0] > self::LIST_LIMIT) {
            $offset += (self::LIST_LIMIT + 1);
            goto getDomains;
        }
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function findByName(string $name): Domain|null
    {
        $request = $this->manager->getClient()->get($name);
        if ($request->getStatusCode() === 404) {
            return null;
        }

        return $this->makeItem($this->parseResponse($request));
    }

    /**
     * @param int $id
     * @return Domain|null
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function find(int $id): Domain|null
    {
        return $this->findByName((string) $id);
    }

    /**
     * @throws GuzzleException
     */
    public function delete(Domain|int $id): bool
    {
        if ($id instanceof Domain) {
            $id = $id->id;
        }

        $request = $this->manager->getClient()->delete((string) $id);
        return $request->getStatusCode() !== 200;
    }

    public function add(DomainCreate $domain): Domain
    {
        $this->manager->getClient()->post('', [
            RequestOptions::JSON => [
                'name' => $domain->name,
                'bind_zone' => $domain->bindZone,
            ]
        ]);

        return $this->findByName($domain->name);
    }

    /**
     * @param array $item
     * @return Domain
     */
    private function makeItem(array $item): Domain
    {
        return new Domain(
            id: $item['id'],
            name: $item['name'],
            userId: $item['user_id'],
            createDate: Carbon::createFromTimestamp($item['create_date']),
            changeDate: Carbon::createFromTimestamp($item['change_date'])
        );
    }
}
