<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Dtos;

use Carbon\Carbon;
use SelectelDnsSdk\Enums\RecordType;

/**
 * Class Record.
 * @package SelectelDnsSdk\Dtos
 * @author Vladimir Pyankov, vladimir@pyankov.pro
 */
class Record
{
    /**
     * @param int $id
     * @param RecordType $type
     * @param string $name
     * @param int $ttl
     * @param Carbon $changeDate
     * @param int|null $priority
     * @param string|null $content
     * @param int|null $weight
     * @param string|null $email
     * @param int|null $expire
     * @param int|null $minimum
     * @param string|null $ns
     * @param int|null $port
     * @param int|null $refresh
     * @param int|null $retry
     * @param int|null $serial
     * @param string|null $target
     */
    public function __construct(
        public readonly int $id,
        public readonly RecordType $type,
        public readonly string $name,
        public readonly int $ttl,
        public readonly Carbon $changeDate,

        // Optional
        public readonly int|null $priority = null,
        public readonly string|null $content = null,
        public readonly int|null $weight = null,
        public readonly string|null $email = null,
        public readonly int|null $expire = null,
        public readonly int|null $minimum = null,
        public readonly string|null $ns = null,
        public readonly int|null $port = null,
        public readonly int|null $refresh = null,
        public readonly int|null $retry = null,
        public readonly int|null $serial = null,
        public readonly string|null $target = null
    ) {}
}
