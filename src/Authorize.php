<?php

namespace Anosmx\TapPayment;

use Illuminate\Support\Facades\Http;

class Authorize extends TapPayment
{
    /**
     * Create an authorize.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createAuthorize(array $attributes)
    {
        $postRequest = [
            "amount" => $attributes['amount'],
            "currency" => $attributes['currency'],
            "threeDSecure" => $attributes['threeDSecure'],
            "save_card" => $attributes['save_card'] ?? false,
            "description" => $attributes['description'],
            "statement_descriptor" => $attributes['statement_descriptor'],
            "metadata" => [
                "udf1" => $attributes['metadata_udf1']
            ],
            "reference" => [
                "transaction" => $attributes['reference_transaction'],
                "order" => $attributes['reference_order']
            ],
            "receipt" => [
                "email" => $attributes['receipt_email'] ?? $this->receipt_by_email,
                "sms" => $attributes['receipt_sms'] ?? $this->receipt_by_sms
            ],
            "customer" => [
                "first_name" => $attributes['customer_first_name'],
                "middle_name" => $attributes['customer_middle_name'],
                "last_name" => $attributes['customer_last_name'],
                "email" => $attributes['customer_email'],
                "phone" => [
                    "country_code" => $attributes['customer_phone_country_code'] ?? $this->country_code,
                    "number" => $attributes['customer_phone_number']
                ]
            ],
            "source" => [
                "id" => $attributes['source_id']
            ],
            "auto" => [
                "type" => $attributes['auto_type'],
                "time" => $attributes['auto_time']
            ],
            "post" => [
                "url" => $attributes['post_url'] ?? $this->post_url
            ],
            "redirect" => [
                "url" => $attributes['redirect_url'] ?? $this->redirect_url
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'authorize', $postRequest);

        return $response->json();
    }

    /**
     * Retrieve an authorize.
     *
     * @param $authorize_id
     * @return array|mixed
     */
    public function retrieveAuthorize($authorize_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'authorize/' . $authorize_id);

        return $response->json();
    }

    /**
     * Update an authorize.
     *
     * @param $authorize_id
     * @param array $attributes
     * @return array|mixed
     */
    public function updateAuthorize($authorize_id, array $attributes)
    {
        $putRequest = [
            "description" => $attributes['description'],
            "receipt" => [
                "email" => $attributes['receipt_email'] ?? $this->receipt_by_email,
                "sms" => $attributes['receipt_sms'] ?? $this->receipt_by_sms
            ],
            "metadata" => [
                "udf2" => $attributes['metadata_udf2']
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->put($this->endpoint . 'authorize/' . $authorize_id, $putRequest);

        return $response->json();
    }

    /**
     * Void an authorize
     *
     * @param $authorize_id
     * @return array|mixed
     */
    public function voidAuthorize($authorize_id)
    {
        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'authorize/' . $authorize_id . '/void', []);

        return $response->json();
    }

    /**
     * List all authorize.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function listAuthorize(array $attributes)
    {
        $postRequest = [
            "period" => [
                "date" => [
                    "from" => $attributes['period_date_from'],
                    "to" => $attributes['period_date_to']
                ]
            ],
            "status" => $attributes['status'],
            "starting_after" => $attributes['starting_after'],
            "limit" => $attributes['limit']
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'authorize/list', $postRequest);

        return $response->json();
    }
}