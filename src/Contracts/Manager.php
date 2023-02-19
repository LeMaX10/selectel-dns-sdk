<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Contracts;

/**
 *
 */
interface Manager
{
    /**
     * @param string|null $name
     * @return Client
     */
    public function getClient(string|null $name = null): Client;

    /**
     * @return DomainRepository
     */
    public function getDomains(): DomainRepository;

    /**
     * @return RecordRepository
     */
    public function getRecords(): RecordRepository;
}
