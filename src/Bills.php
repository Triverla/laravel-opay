<?php

namespace Triverla\LaravelOpay;

use Triverla\LaravelOpay\Exceptions\FailedRequestException;
use Triverla\LaravelOpay\Helpers\BulkBillsListPayload;
use Triverla\LaravelOpay\Helpers\BulkStatusRequest;

abstract class Bills
{
    private Opay $opay;
    private $config;

    public function __construct(Opay $opay, $config)
    {
        $this->config = $config;
        $this->opay = $opay;
    }

    public function bettingProviders()
    {
        $endpoint = "{$this->opay->baseUrl}{$this->opay->v3}/bills/betting-providers";

        $payload = [];

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

    public function validate(string $serviceType, string $provider, string $customerId)
    {
        $endpoint = "{$this->opay->baseUrl}{$this->opay->v3}/bills/validate";

        $payload = [
            "serviceType" => $serviceType,
            "provider" => $provider,
            "customerId" => $customerId
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

    public function bulkBills(BulkBillsListPayload $billsListPayload, string $callbackUrl, string $serviceType)
    {
        $endpoint = "{$this->opay->baseUrl}{$this->opay->v3}/bills/validate";

        $payload = [
            "bulkData" => $billsListPayload->toArray(),
            "callbackUrl" => $callbackUrl,
            "serviceType" => $serviceType

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

    public function bulkStatus(BulkStatusRequest $bulkStatusRequest, string $serviceType)
    {
        $endpoint = "{$this->opay->baseUrl}{$this->opay->v3}/bills/bulk-status";

        $payload = [
            "bulkStatusRequest" => $bulkStatusRequest->toArray(),
            "serviceType" => $serviceType

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
}
