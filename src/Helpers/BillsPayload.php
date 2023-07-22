<?php

namespace Triverla\LaravelOpay\Helpers;

class BillsPayload
{
    private string $reference;
    private float $amount;
    private string $customerId;
    private string $provider;
    private string $currency;
    private string $country;

    public function __construct(string $reference, float $amount, string $customerId, string $provider, string $currency = 'NGN', string $country = 'NG')
    {
        $this->reference = $reference;
        $this->amount = $amount;
        $this->customerId = $customerId;
        $this->provider = $provider;
        $this->currency = $currency;
        $this->country = $country;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'country' => $this->country,
            'currency' => $this->currency,
            'customerId' => $this->customerId,
            'provider'  => $this->provider,
            'reference' => $this->reference
        ];
    }
}
