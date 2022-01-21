<?php

namespace Anosmx\TapPayment;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class Card extends TapPayment
{
    /**
     * List customer cards.
     *
     * @param $customer_id
     * @return array|mixed
     */
    public function listCards($customer_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'card/' . $customer_id);

        return $response;
    }

    /**
     * Verify customer card.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function verifyCard(array $attributes)
    {
        $postRequest = [
            "currency" => $this->currency,
            "threeDSecure" => $attributes['threeDSecure'] ?? '',
            "save_card" => $attributes['save_card'] ?? '',
            "metadata" => $attributes['metadata'],
            "customer" => [
                "first_name" => $attributes['customer_first_name'] ?? '',
                "middle_name" => $attributes['customer_middle_name'] ?? '',
                "last_name" => $attributes['customer_last_name'] ?? '',
                "email" => $attributes['customer_email'] ?? '',
                "phone" => [
                    "country_code" => $this->country_code,
                    "number" => $attributes['customer_phone_number'] ?? ''
                ]
            ],
            "source" => [
                "id" => $attributes['source_id'] ?? ''
            ],
            "redirect" => [
                "url" => $attributes['redirect_url'] ?? ''
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'card/verify', $postRequest);

        return $response;
    }

    /**
     * Save customer card.
     *
     * @param $customer_id
     * @param $attributes
     * @return array|mixed
     */
    public function saveCard($customer_id, array $attributes)
    {
        $postRequest = [
            "currency" => $attributes['source'],
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'card/' . $customer_id, $postRequest);

        return $response;
    }

    /**
     * Retrieve customer card.
     *
     * @param $customer_id
     * @param $card_id
     * @return array|mixed
     */
    public function retrieveCard($customer_id, $card_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'card/' . $customer_id . '/' . $card_id);

        return $response;
    }

    /**
     * Retrieve a verify card.
     *
     * @param $verify_id
     * @return array|mixed
     */
    public function retrieveVerifyCard($verify_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'card/verify/' . $verify_id);

        return $response;
    }

    /**
     * Delete customer card.
     *
     * @param $customer_id
     * @param $card_id
     * @return array|mixed
     */
    public function deleteCard($customer_id, $card_id)
    {
        $response = Http::withToken($this->api_token)
            ->delete($this->endpoint . 'card/' . $customer_id . '/' . $card_id);

        return $response;
    }
}