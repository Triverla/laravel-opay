<?php

namespace Triverla\LaravelOpay\Helpers;

class BankTransferPayload
{

    private string $reference;
    private float $amount;
    private string $reason;
    private ?string $currency;
    private ?string $country;
    private string $name;
    private string $bankCode;
    private string $bankAccountNumber;

    public function __construct(string $reference, float $amount, string $reason, string $name, string $bankCode, string $bankAccountNumber, string $currency = null, string $country = null)
    {
        $this->reference = $reference;
        $this->amount = $amount;
        $this->reason = $reason;
        $this->name = $name;
        $this->bankCode = $bankCode;
        $this->bankAccountNumber = $bankAccountNumber;
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
            'receiver' => [
                'name' => $this->name,
                'bankCode' => $this->bankCode,
                'bankAccountNumber' => $this->bankAccountNumber
            ],
            'reference' => $this->reference
        ];
    }
}
