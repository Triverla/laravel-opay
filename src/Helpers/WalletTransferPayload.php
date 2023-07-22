<?php

namespace Triverla\LaravelOpay;

class WalletTransferPayload
{

    private string $reference;
    private float $amount;
    private string $reason;
    private string $type;
    private ?string $phoneNumber;
    private ?string $merchantId;
    private ?string $currency;
    private ?string $country;

    public function __construct(string $reference, float $amount, string $reason, string $type, string $phoneNumber = null, string $merchantId = null, string $currency = null, string $country = null)
    {
        $this->reference = $reference;
        $this->amount = $amount;
        $this->reason = $reason;
        $this->type = $type;
        $this->phoneNumber = $phoneNumber;
        $this->merchantId = $merchantId;
        $this->currency = $currency;
        $this->country = $country;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'country' => $this->country ?? 'NG',
            'currency' => $this->currency ?? 'NGN',
            'reason' => $this->reason,
            'receiver' => $this->type == strtoupper('user') ? ['type' => 'USER', 'phoneNumber' => $this->phoneNumber] : ['type' => 'MERCHANT', 'merchantId' => $this->merchantId],
            'reference' => $this->reference
        ];
    }
}
