<?php

namespace Triverla\LaravelOpay\Helpers;

class WalletTransferPayloadList
{
    private array $transferList = [];

    public function __construct(WalletTransferPayload ...$payloads)
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
