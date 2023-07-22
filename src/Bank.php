<?php

namespace Triverla\LaravelOpay;

use Triverla\LaravelOpay\Exceptions\FailedRequestException;

abstract class Bank
{
    private Opay $opay;
    private $config;

    public function __construct(Opay $opay, $config)
    {
        $this->config = $config;
        $this->opay = $opay;
    }

    public function countries()
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/countries";

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

    public function banks()
    {
        $endpoint =  "{$this->opay->baseUrl}{$this->opay->v3}/banks";

        $payload = [
            "countryCode" => "NG"
        ];

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
}
