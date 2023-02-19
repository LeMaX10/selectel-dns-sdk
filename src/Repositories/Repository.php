<?php
declare(strict_types=1);

namespace SelectelDnsSdk\Repositories;

use SelectelDnsSdk\Manager;
use SelectelDnsSdk\Repositories\Traits\ResponseParser;

abstract class Repository
{
    use ResponseParser;

    protected const LIST_LIMIT = 1000;

    /**
     * @param Manager $manager
     */
    public function __construct(
        protected Manager $manager
    ) {}
}
