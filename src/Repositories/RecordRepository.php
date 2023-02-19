<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Repositories;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use SelectelDnsSdk\Dtos\Record;
use SelectelDnsSdk\Dtos\RecordCreate;
use SelectelDnsSdk\Enums\RecordType;
use SelectelDnsSdk\Contracts\RecordRepository as RecordRepositoryContract;

/**
 * Class DomainRepository.
 * @package SelectelDns\Repositories
 * @author Vladimir Pyankov, vladimir@pyankov.pro
 */
final class RecordRepository extends Repository implements RecordRepositoryContract
{
    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function all(string $domain): \Generator
    {
        $offset = 0;

        getRecords:
        $request = $this->manager
            ->getClient()
            ->get("$domain/records/", [
                'params' => [
                    'offset' => $offset,
                ],
            ]);

        foreach($this->parseResponse($request) as $item) {
            yield $this->makeItem($item);
        }

        if ($request->getHeader('X-Total-Count')[0] > self::LIST_LIMIT) {
            $offset += self::LIST_LIMIT + 1;
            goto getRecords;
        }
    }

    public function find(int|string $domain, int $id): Record|null
    {
        $request = $this->manager->getClient()->get("$domain/records/$id");
        if ($request->getStatusCode() === 404) {
            return null;
        }

        return $this->makeItem($this->parseResponse($request));
    }

    public function delete(int|string $domain, int $id): bool
    {
        $request = $this->manager->getClient()->delete("$domain/records/$id");
        return $request->getStatusCode() === 200;
    }

    public function add(int|string $domain, RecordCreate $recordCreate): Record
    {
        $request = $this->manager->getClient()->post(
            "$domain/records",
            [
                RequestOptions::JSON => $recordCreate->toArray(),
            ]
        );

        return $this->makeItem($this->parseResponse($request));
    }


    /**
     * @param array $item
     * @return Record
     */
    private function makeItem(array $item): Record
    {
        $item['type'] = RecordType::tryFromName($item['type']);
        $item['changeDate'] = Carbon::createFromTimestamp($item['change_date']);
        unset($item['change_date']);

        return new Record(...$item);
    }
}
