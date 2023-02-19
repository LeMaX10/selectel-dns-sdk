<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Dtos;

use Carbon\Carbon;

final class Domain
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $userId,
        public readonly Carbon $createDate,
        public readonly Carbon $changeDate,
        public readonly array|null $ips = null,
    ) {}
}
