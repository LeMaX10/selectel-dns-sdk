<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Dtos;

use Carbon\Carbon;

final class DomainCreate
{
    public function __construct(
        public readonly string $name,
        public readonly string $bindZone = ''
    ) {}
}
