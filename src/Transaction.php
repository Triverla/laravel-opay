<?php

namespace Triverla\LaravelOpay;

use Triverla\LaravelOpay\Exceptions\FailedRequestException;

abstract class Transaction
{
    private Opay $opay;
    private $config;

    public function __construct(Opay $opay, $config)
    {
        $this->config = $config;
        $this->opay = $opay;
    }

    /**
     * @param string $reference
     * @param float $amount
     * @param string $firstName
     * @param string $lastName
     * @param string $customerEmail
     * @param string $cardNumber
     * @param string $cardDateMonth
     * @param string $cardDateYear
     * @param string $cardCVC
     * @param string $return3dsUrl
     * @param string $bankAccountNumber
     * @param string $bankCode
     * @param string $reason
     * @param string $callbackUrl
     * @param string $expiresAt
     * @param string|null $billingZip
     * @param string|null $billingCity
     * @param string|null $billingAddress
     * @param string|null $billingState
     * @param string|null $billingCountry
     * @param string $currency
     * @param string $country
     * @return object|null
     * @throws FailedRequestException
     */
    public function initializeCardTransaction(string $reference, float $amount, string $firstName, string $lastName, string $customerEmail, string $cardNumber,
                                              string $cardDateMonth, string $cardDateYear, string $cardCVC, string $return3dsUrl, string $bankAccountNumber,
                                              string $bankCode, string $reason, string $callbackUrl, string $expiresAt, string $billingZip = null, string $billingCity = null,
                                              string $billingAddress = null, string $billingState = null, string $billingCountry = null,
                                              string $currency = 'NGN', string $country = 'NG')
    {
        $endpoint = "{$this->opay->baseUrl}{$this->opay->v3}/transaction/initialize";

        $payload = [
            "reference" => $reference,
            "amount" => $amount,
            "currency" => $currency,
            "country" => $country,
            "payType" => "bankcard",
            "firstName" => $firstName,
            "lastName" => $lastName,
            "customerEmail" => $customerEmail,
            "cardNumber" => $cardNumber,
            "cardDateMonth" => $cardDateMonth,
            "cardDateYear" => $cardDateYear,
            "cardCVC" => $cardCVC,
            "return3dsUrl" => $return3dsUrl,
            "bankAccountNumber" => $bankAccountNumber,
            "bankCode" => $bankCode,
            "reason" => $reason,
            "callbackUrl" => $callbackUrl,
            "expireAt" => $expiresAt,
            "billingZip" => $billingZip,
            "billingCity" => $billingCity,
            "billingAddress" => $billingAddress,
            "billingState" => $billingState,
            "billingCountry" => $billingCountry
        ];

        $response = $this->opay->withBearerAuth($payload->toArray())->post($endpoint, $payload->toArray());

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}", $result->status ?? 500);
        }

        if ($result->code != '00000') {
            return $result;
        }

        return $result->data;
    }

    /**
     * @param string $reference
     * @param float $amount
     * @param string $customerPhone
     * @param string $customerEmail
     * @param string $reason
     * @param string $callbackUrl
     * @param string $expiresAt
     * @param string $token
     * @param string $currency
     * @param string $country
     * @return object|null
     * @throws FailedRequestException
     */
    public function initializeTokenTransaction(string $reference, float $amount, string $customerPhone, string $customerEmail, string $reason, string $callbackUrl, string $expiresAt, string $token,
                                               string $currency = 'NGN', string $country = 'NG')
    {
        $endpoint = "{$this->opay->baseUrl}{$this->opay->v3}/transaction/initialize";

        $payload = [
            "reference" => $reference,
            "amount" => $amount,
            "currency" => $currency,
            "country" => $country,
            "payType" => "token",
            "token" => $token,
            "customerPhone" => $customerPhone,
            "customerEmail" => $customerEmail,
            "reason" => $reason,
            "callbackUrl" => $callbackUrl,
            "expireAt" => $expiresAt,
        ];

        $response = $this->opay->withAuth()->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}", $result->status ?? 500);
        }

        if ($result->code != '00000') {
            return $result;
        }

        return $result->data;
    }

    /**
     * @param string $reference
     * @param float $amount
     * @param string $customerPhone
     * @param string $return3dsUrl
     * @param string $bankAccountNumber
     * @param string $bankCode
     * @param string $reason
     * @param string $bvn
     * @param string $dobDay
     * @param string $dobMonth
     * @param string $dobYear
     * @param string $currency
     * @param string $country
     * @return object|null
     * @throws FailedRequestException
     */
    public function initializeBankAccountTransaction(string $reference, float $amount, string $customerPhone, string $return3dsUrl, string $bankAccountNumber,
                                                     string $bankCode, string $reason, string $bvn, string $dobDay, string $dobMonth, string $dobYear,
                                                     string $currency = 'NGN', string $country = 'NG')
    {
        $endpoint = "{$this->opay->baseUrl}{$this->opay->v3}/transaction/initialize";

        $payload = [
            "reference" => $reference,
            "amount" => $amount,
            "currency" => $currency,
            "country" => $country,
            "payType" => "bankaccount",
            "return3dsUrl" => $return3dsUrl,
            "bankAccountNumber" => $bankAccountNumber,
            "bankCode" => $bankCode,
            "customerPhone" => $customerPhone,
            "reason" => $reason,
            "bvn" => $bvn,
            "dobDay" => $dobDay,
            "dobMonth" => $dobMonth,
            "dobYear" => $dobYear
        ];

        $response = $this->opay->withAuth()->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}", $result->status ?? 500);
        }

        if ($result->code != '00000') {
            return $result;
        }

        return $result->data;
    }

    /**
     * @param string $reference
     * @param string $orderNo
     * @return object|null
     * @throws FailedRequestException
     */
    public function checkTransactionStatus(string $reference, string $orderNo)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transaction/status";

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

    /**
     * @param string $reference
     * @param string $orderNo
     * @param string $pin
     * @return object|null
     * @throws FailedRequestException
     */
    public function transactionInputPIN(string $reference, string $orderNo, string $pin)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transaction/input-pin";

        $payload = [
            'orderNo' => $orderNo,
            'reference' => $reference,
            'pin' => $pin
        ];

        $response = $this->opay->withAuth()->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}");
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    /**
     * @param string $reference
     * @param string $orderNo
     * @param string $otp
     * @return object|null
     * @throws FailedRequestException
     */
    public function transactionInputOTP(string $reference, string $orderNo, string $otp)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transaction/input-otp";

        $payload = [
            'orderNo' => $orderNo,
            'reference' => $reference,
            'otp' => $otp
        ];

        $response = $this->opay->withAuth()->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}");
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    /**
     * @param string $reference
     * @param string $orderNo
     * @param string $phone
     * @return object|null
     * @throws FailedRequestException
     */
    public function transactionInputPhone(string $reference, string $orderNo, string $phone)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transaction/input-phone";

        $payload = [
            'orderNo' => $orderNo,
            'reference' => $reference,
            'phone' => $phone
        ];

        $response = $this->opay->withAuth()->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}");
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    /**
     * @param string $reference
     * @param string $orderNo
     * @param string $dob
     * @return object|null
     * @throws FailedRequestException
     */
    public function transactionInputDob(string $reference, string $orderNo, string $dob)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transaction/input-dob";

        $payload = [
            'orderNo' => $orderNo,
            'reference' => $reference,
            'dob' => $dob
        ];

        $response = $this->opay->withAuth()->post($endpoint, $payload);

        $result = $response->object();
        if ($response->failed()) {
            throw new FailedRequestException($result->failureReason ?? "{$result->error} - {$result->error_description}");
        }

        if($result->code != '00000'){
            return $result;
        }

        return $result->data;
    }

    public function initiateBankTransferTransaction(string $reference, string $userPhone, float $amount, string $userRequestIp, string $productName, string $productDesc, int $expiresAt = 30, string $currency = 'NGN')
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transaction/bankTransfer/initialize";

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

    public function getBankTransferTransactionStatus(string $reference, string $orderNo)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transaction/bankTransfer/status";

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

    public function initiateUSSDTransaction(string $reference, string $userPhone, float $amount, string $userRequestIp, string $productName, string $productDesc, int $expiresAt = 30, string $currency = 'NGN')
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transaction/ussd/initialize";

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

    public function getUSSDTransactionStatus(string $reference, string $orderNo)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/transaction/ussd/status";

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
}
