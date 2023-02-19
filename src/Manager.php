<?php
declare(strict_types=1);

namespace SelectelDnsSdk;

use SelectelDnsSdk\Exceptions\ClientConfigurationNotFoundException;
use SelectelDnsSdk\Exceptions\ClientNotFoundException;
use SelectelDnsSdk\Exceptions\TokenNotFoundException;
use SelectelDnsSdk\Contracts\DomainRepository;
use SelectelDnsSdk\Contracts\RecordRepository;
use SelectelDnsSdk\Contracts\Manager as ManagerContract;

final class Manager implements ManagerContract
{
    private array $resolved = [];

    public function __construct(
        private readonly array $config
    )
    {}

    public function getClient(string|null $name = null): Client
    {
        $name = $name ?: $this->config['default'];
        if (!isset($this->resolved[$name])) {
            $this->resolved[$name] = $this->resolve($name);
        }

        return $this->resolved[$name];
    }

    public function getDomains(): DomainRepository
    {
        if (!isset($this->resolved['domainRepository'])) {
            $repositoryClass = $this->config['repositories']['domain'];
            $this->resolved['domainRepository'] = new $repositoryClass($this);
        }

        return $this->resolved['domainRepository'];
    }

    public function getRecords(): RecordRepository
    {
        if (!isset($this->resolved['recordRepository'])) {
            $repositoryClass = $this->config['repositories']['record'];
            $this->resolved['recordRepository'] = new $repositoryClass($this);
        }

        return $this->resolved['recordRepository'];
    }

    protected function resolve(string $name): Client
    {
        if (!array_key_exists($name, $this->config['services'])) {
            throw new ClientConfigurationNotFoundException();
        }

        $clientConfiguration = $this->config['services'][$name];
        if (!array_key_exists('class', $clientConfiguration)) {
            throw new ClientNotFoundException();
        }

        if (!array_key_exists('token', $clientConfiguration)) {
            throw new TokenNotFoundException();
        }

        $clientClass = $clientConfiguration['class'];
        return new $clientClass($clientConfiguration['token']);
    }
}
