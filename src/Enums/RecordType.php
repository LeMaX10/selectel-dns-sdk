<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Enums;

enum RecordType
{
    case SOA;
    case SRV;
    case MX;
    case CNAME;
    case TXT;
    case A;
    case AAAA;
    case NS;
    case PTR;

    public static function tryFromName(string $name): ?static
    {
        $reflection = new \ReflectionEnum(static::class);

        return $reflection->hasCase($name)
            ? $reflection->getCase($name)->getValue()
            : null;
    }
}
