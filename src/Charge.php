<?php

namespace Anosmx\TapPayment;

use Illuminate\Support\Facades\Http;

class Charge extends TapPayment
{
    /**
     * List all charges.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function listCharges(array $attributes)
    {
        $postRequest = [
            "period" => [
                "date" => [
                    "from" => $attributes['period_date_from'],
                    "to" => $attributes['period_date_to']
                ],
                "type" => $attributes['period_type']
            ],
            "status" => $attributes['status'],
            "starting_after" => $attributes['starting_after'],
            "limit" => $attributes['limit']
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'charges/list', $postRequest);

        return $response;
    }

    /**
     * Create charge.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createCharge(array $attributes)
    {
        $postRequest = [
            "amount" => $attributes['amount'],
            "currency" => $attributes['currency'] ?? $this->currency,
            "threeDSecure" => $attributes['threeDSecure'],
            "save_card" => $attributes['save_card'],
            "description" => $attributes['description'],
            "statement_descriptor" => $attributes['statement_descriptor'],
            "metadata" => [
                "udf1" => $attributes['metadata_udf1'],
                "udf2" => $attributes['metadata_udf2']
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
                    "country_code" => $attributes['phone_country_code'] ?? $this->country_code,
                    "number" => $attributes['phone_number']
                ]
            ],
            "merchant" => [
                "id" => $attributes['merchant_id']
            ],
            "source" => [
                "id" => $attributes['source_id']
            ],
            "post" => [
                "url" => $attributes['post_url'] ?? $this->post_url
            ],
            "redirect" => [
                "url" => $attributes['redirect_url'] ?? $this->redirect_url
            ]
        ];

        $response = Http::withToken($this->api_token)->withHeaders([
            'lang_code' => $this->lang_code ?? 'ar'
        ])
            ->post($this->endpoint . 'charges', $postRequest);

        return $response;
    }

    /**
     * Retrieve a charge
     *
     * @param $charge_id
     * @return array|mixed
     */
    public function retrieveCharge($charge_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'charges/' . $charge_id);

        return $response;
    }

    /**
     * Update a charge.
     *
     * @param $charge_id
     * @param array $attributes
     * @return array|mixed
     */
    public function updateCharge($charge_id, array $attributes)
    {
        $putRequest = [
            "description" => $attributes['description'],
            "receipt" => [
                "email" => $attributes['receipt_email'] ?? $this->receipt_by_email,
                "sms" => $attributes['receipt_sms'] ?? $this->receipt_by_sms
            ],
            "metadata" => [
                "udf2" => $attributes['metadata_udf1']
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->put($this->endpoint . 'charges/' . $charge_id, $putRequest);

        return $response;
    }
}