<?php

namespace Triverla\LaravelOpay;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Opay
{
    public string $baseUrl;
    public string $v3 = "/api/v3";
    private $config;
    private $client;
    private $transfer;
    private $bank;
    private $inquiry;
    private $wallet;
    private $account;
    private $transaction;
    private $bills;

    public function __construct(string $baseUrl, $config)
    {
        $this->baseUrl = $baseUrl;
        $this->config = $config;
    }

    /**
     * @param $payload
     * @return PendingRequest
     */
    public function withBearerAuth($payload): PendingRequest
    {
        $this->client = Http::withHeaders([
            'Authorization' => "Bearer {$this->generateSignature($payload)}",
            'Content-Type' => 'application/json',
            'MerchantID' => $this->config['merchant_id']
        ]);

        return $this->client;
    }

    /**
     * @return PendingRequest
     */
    public function withAuth(): PendingRequest
    {
        $this->client = Http::withHeaders([
            'Authorization' => "Bearer {$this->config['public_key']}",
            'Content-Type' => 'application/json',
            'MerchantId' => $this->config['merchant_id']
        ]);

        return $this->client;
    }

    /**
     * @param $payload
     * @return bool|string
     */
    private function generateSignature($payload): bool|string
    {
        $secretKey = $this->config['secret_key'];
        return hash_hmac('sha512', json_encode($payload), $secretKey);
    }

    /**
     * @return Transfer
     */
    public function transfer(): Transfer
    {
        if (is_null($this->transfer))
            $this->transfer = new class($this, $this->config) extends Transfer {
            };
        return $this->transfer;
    }

    /**
     * @return Bank
     */
    public function bank(): Bank
    {
        if (is_null($this->bank))
            $this->bank = new class($this, $this->config) extends Bank {
            };
        return $this->bank;
    }

    /**
     * @return Inquiry
     */
    public function inquiry(): Inquiry
    {
        if (is_null($this->inquiry))
            $this->inquiry = new class($this, $this->config) extends Inquiry {
            };
        return $this->inquiry;
    }

    /**
     * @return Wallet
     */
    public function wallet(): Wallet
    {
        if (is_null($this->wallet))
            $this->wallet = new class($this, $this->config) extends Wallet {
            };
        return $this->wallet;
    }

    /**
     * @return Account
     */
    public function account(): Account
    {
        if (is_null($this->account))
            $this->account = new class($this, $this->config) extends Account {
            };
        return $this->account;
    }

    /**
     * @return Transaction
     */
    public function transaction(): Transaction
    {
        if (is_null($this->transaction))
            $this->transaction = new class($this, $this->config) extends Transaction {
            };
        return $this->transaction;
    }

    /**
     * @return Bills
     */
    public function bills(): Bills
    {
        if (is_null($this->bills))
            $this->bills = new class($this, $this->config) extends Bills {
            };
        return $this->bills;
    }
}
