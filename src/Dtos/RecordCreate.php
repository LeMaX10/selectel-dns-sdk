<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Dtos;

use SelectelDnsSdk\Dtos\Traits\Arrayable;
use SelectelDnsSdk\Enums\RecordType;

final class RecordCreate
{
    use Arrayable;

    public function __construct(
        public readonly RecordType $type,
        public readonly string $name,
        public readonly string $content,

        // Optional
        public readonly int $ttl = 86400,
        public readonly int|null $priority = null,
        public readonly int|null $weight = null,
        public readonly string|null $email = null,
        public readonly int|null $port = null,
        public readonly string|null $target = null
    ){}
}
