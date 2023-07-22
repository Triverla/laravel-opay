<?php

namespace Triverla\LaravelOpay;

use Triverla\LaravelOpay\Exceptions\FailedRequestException;

abstract class Wallet
{
    private Opay $opay;
    private $config;

    public function __construct(Opay $opay, $config)
    {
        $this->config = $config;
        $this->opay = $opay;
    }

    public function  initiateTransaction(string $reference, string $userPhone, float $amount, string $userRequestIp, string $productName, string $productDesc, int $expiresAt = 30, string $currency = 'NGN')
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/certpay/initialize";

        $payload = [
            'amount' => $amount,
            'currency' => $currency,
            'expiresAt' => $expiresAt,
            'productDesc' => $productDesc,
            'productName' => $productName,
            'reference' => $reference,
            'userPhone' => $userPhone,
            'userRequestIp' => $userRequestIp,
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

    public function  authorizeTransaction(string $reference, string $orderNo, string $userPhone, string $pin)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/certpay/verifyPIN";

        $payload = [
            'orderNo' => $orderNo,
            'pin' => $pin,
            'reference' => $reference,
            'userPhone' => $userPhone
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

    public function  sendOTP(string $reference, string $orderNo, string $payMethod)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/certpay/sendOTP";

        $payload = [
            'orderNo' => $orderNo,
            'payMethod' => $payMethod,
            'reference' => $reference
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

    public function  verifyOTP(string $reference, string $orderNo, string $payMethod, string $otp)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/certpay/verifyOTP";

        $payload = [
            'orderNo' => $orderNo,
            'otp' => $otp,
            'payMethod' => $payMethod,
            'reference' => $reference
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

    public function  verifyStatus(string $reference, string $orderNo)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/certpay/status";

        $payload = [
            'orderNo' => $orderNo,
            'reference' => $reference
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

    public function  closeTransaction(string $reference, string $orderNo)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/certpay/close";

        $payload = [
            'orderNo' => $orderNo,
            'reference' => $reference
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

    public function  initializeRefund(string $reference, string $refundReference, float $refundAmount, string $orderNo, string $currency = 'NGN')
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/certpay/refund";

        $payload = [
            'currency' => $currency,
            'orderNo' => $orderNo,
            'reference' => $reference,
            'refundAmount' => $refundAmount,
            'refundReference' => $refundReference

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

    public function  verifyRefundStatus(string $reference, string $refundReference, float $refundAmount, string $refundOrderNo)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/certpay/refund";

        $payload = [
            'reference' => $reference,
            'refundAmount' => $refundAmount,
            'refundOrderNo' => $refundOrderNo,
            'refundReference' => $refundReference
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
