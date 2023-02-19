<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Dtos\Traits;

trait Arrayable
{
    public function toArray(): array
    {
        $data = [];
        $class = new \ReflectionClass(static::class);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $data[$property->getName()] = $property->getValue($this);
        }

        return $data;
    }
}
