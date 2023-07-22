<?php

namespace Triverla\LaravelOpay;

class BankTransferPayloadList
{
    private array $transferList = [];

    public function __construct(BankTransferPayload ...$payloads)
    {
        foreach ($payloads as $payload) {
            $this->transferList[] = $payload->toArray();
        }
    }

    public function toArray(): array
    {
        return $this->transferList;
    }
}
