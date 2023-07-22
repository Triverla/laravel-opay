<?php

namespace Triverla\LaravelOpay\Helpers;

use Triverla\LaravelOpay\BankTransferPayload;

class BulkBillsListPayload
{
    private array $bulkData = [];

    public function __construct(BillsPayload ...$payloads)
    {
        foreach ($payloads as $payload) {
            $this->bulkData[] = $payload->toArray();
        }
    }

    public function toArray(): array
    {
        return $this->bulkData;
    }
}
