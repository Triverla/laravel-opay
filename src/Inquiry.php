<?php

namespace Triverla\LaravelOpay;

use Triverla\LaravelOpay\Exceptions\FailedRequestException;

abstract class Inquiry
{
    private Opay $opay;
    private $config;

    public function __construct(Opay $opay, $config)
    {
        $this->config = $config;
        $this->opay = $opay;
    }

    public function balance()
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/balances";

        $payload = [];

        $response = $this->opay->withAuth()->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}", $result->status ?? 500);
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    public function validateOPayUser(string $phoneNumber)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/info/user";

        $payload = [
            'phoneNumber' => $phoneNumber
        ];

        $response = $this->opay->withAuth()->post($endpoint, $payload);

        $result = $response->object();

        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason, $result->status ?? 500);
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    public function validateOPayMerchant(string $email)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/info/merchant";

        $payload = [
            'email' => $email
        ];

        $response = $this->opay->withBearerAuth($payload)->post($endpoint, $payload);

        $result = $response->object();

        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason, $result->status ?? 500);
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    public function validateBankAccountNumber(string $bankCode, string $bankAccountNumber, string $countryCode = 'NG')
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/verification/accountNumber/resolve";

        $payload = [
            'bankAccountNumber' => $bankAccountNumber,
            'bankCode' => $bankCode,
            'countryCode' => $countryCode
        ];

        $response = $this->opay->withBearerAuth($payload)->post($endpoint, $payload);

        $result = $response->object();

        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason, $result->status ?? 500);
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }
}
