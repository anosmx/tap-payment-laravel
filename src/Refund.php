<?php

namespace Anosmx\TapPayment;

use Illuminate\Support\Facades\Http;

class Refund extends TapPayment
{
    /**
     * List all refunds.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function listRefunds(array $attributes)
    {
        $postRequest = [
            "period" => [
                "date" => [
                    "from" => $attributes['period_date_from'],
                    "to" => $attributes['period_date_to']
                ],
            ],
            "starting_after" => $attributes['starting_after'],
            "limit" => $attributes['limit']
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'refunds/list', $postRequest);

        return $response->json();
    }

    /**
     * Create a refund.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createRefund(array $attributes)
    {
        $postRequest = [
            "charge_id" => $attributes['charge_id'],
            "amount" => $attributes['amount'],
            "currency" => $attributes['currency'] ?? $this->currency,
            "description" => $attributes['description'],
            "reason" => $attributes['reason'],
            "reference" => [
                "merchant" => $attributes['reference_merchant']
            ],
            "metadata" => [
                "udf1" => $attributes['metadata_udf1'],
                "udf2" => $attributes['metadata_udf2']
            ],
            "post" => [
                "url" => $attributes['post_url'] ?? $this->post_url
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'refunds', $postRequest);

        return $response->json();
    }

    /**
     * Retrieve a refund.
     *
     * @param $refund_id
     * @return array|mixed
     */
    public function retrieveRefund($refund_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'refunds/' . $refund_id);

        return $response->json();
    }

    /**
     * Update a refund.
     *
     * @param $refund_id
     * @param array $attributes
     * @return array|mixed
     */
    public function updateRefund($refund_id, array $attributes)
    {
        $putRequest = [
            "metadata" => [
                "Order Number" => $attributes['metadata_order_number']
            ],
        ];

        $response = Http::withToken($this->api_token)
            ->put($this->endpoint . 'refunds/' . $refund_id, $putRequest);

        return $response->json();
    }
}