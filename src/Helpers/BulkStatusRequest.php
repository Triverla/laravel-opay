<?php

namespace Triverla\LaravelOpay\Helpers;

class BulkStatusRequest
{
    private array $bulkRequests = [];

    public function __construct(StatusRequest ...$payloads)
    {
        foreach ($payloads as $payload) {
            $this->bulkRequests[] = $payload->toArray();
        }
    }

    public function toArray(): array
    {
        return $this->bulkRequests;
    }
}
