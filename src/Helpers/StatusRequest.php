<?php

namespace Triverla\LaravelOpay\Helpers;

class StatusRequest
{
    private string $reference;
    private string $orderNo;

    public function __construct(string $reference, string $orderNo)
    {
        $this->reference = $reference;
        $this->orderNo = $orderNo;
    }

    public function toArray(): array
    {
        return [
            'orderNo' => $this->orderNo,
            'reference' => $this->reference
        ];
    }
}
