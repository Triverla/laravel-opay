<?php

namespace Triverla\LaravelOpay;

use Triverla\LaravelOpay\Exceptions\FailedRequestException;

abstract class Transfer
{
    private Opay $opay;
    private $config;

    public function __construct(Opay $opay, $config)
    {
        $this->config = $config;
        $this->opay = $opay;
    }

    public function opayWallet(WalletTransferPayload $payload)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transfer/toWallet";

        $response = $this->opay->withBearerAuth($payload->toArray())->post($endpoint, $payload->toArray());

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}", $result->status ?? 500);
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    public function queryWalletTransferStatus(string $reference, string $orderNo)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transfer/status/toWallet";

        $payload = [
            'orderNo' => $orderNo,
            'reference' => $reference
        ];

        $response = $this->opay->withBearerAuth($payload)->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}");
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    public function opayWalletBatch(WalletTransferPayloadList $payloadList)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transfer/batchToWallet";

        $payload = [
            'list' => $payloadList->toArray()
        ];

        $response = $this->opay->withBearerAuth($payload)->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}", $result->status ?? 500);
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    public function bankAccount(BankTransferPayload $payload)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transfer/toBank";

        $response = $this->opay->withBearerAuth($payload->toArray())->post($endpoint, $payload->toArray());

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}", $result->status ?? 500);
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    public function queryBankTransferStatus(string $reference, string $orderNo)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transfer/status/toBank";

        $payload = [
            'orderNo' => $orderNo,
            'reference' => $reference
        ];

        $response = $this->opay->withBearerAuth($payload)->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}");
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    public function bankAccountBatch(BankTransferPayloadList $payloadList)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transfer/batchToBank";

        $payload = [
            'list' => $payloadList->toArray()
        ];

        $response = $this->opay->withBearerAuth($payload)->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}", $result->status ?? 500);
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }
}
