<?php

namespace Triverla\LaravelOpay;

use Exception;
use Triverla\LaravelOpay\Exceptions\FailedRequestException;

abstract class Account
{
    private Opay $opay;
    private $config;

    public function __construct(Opay $opay, $config)
    {
        $this->config = $config;
        $this->opay = $opay;
    }


    public function createUserAccount(string $phoneNumber, string $email, string $firstName, string $lastName, string $password, string $address, string $otp)
    {

        if (empty($phoneNumber))
            throw new Exception('Phone Number can\'t be empty');
        else if (preg_match('/^\+?\d+$/', $phoneNumber))
            throw new Exception('Account Number must be numeric');

        if (empty($password))
            throw new Exception('Password can\'t be empty');

        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/info/user/create";

        $payload = [
            'address' => $address,
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'password' => $password,
            'phoneNumber' => $phoneNumber,
            'otp' => $otp
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

    public function sendOTP(string $phoneNumber)
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/info/user/sendOTP";

        $payload = [
            'phoneNumber' => $phoneNumber
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
