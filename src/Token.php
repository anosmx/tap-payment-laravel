<?php

namespace Anosmx\TapPayment;

use Illuminate\Support\Facades\Http;

class Token extends TapPayment
{
    /**
     * Create a token (Card).
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createTokenCard(array $attributes)
    {
        $postRequest = [
            "card" => [
                "number" => $attributes['card_number'],
                "exp_month" => $attributes['card_exp_month'],
                "exp_year" => $attributes['card_exp_tear'],
                "cvc" => $attributes['card_cvc'],
                "name" => $attributes['card_name'],
                "address" => [
                    "country" => $attributes['card_address_country'],
                    "line1" => $attributes['card_address_line1'],
                    "city" => $attributes['card_address_city'],
                    "street" => $attributes['card_address_street'],
                    "avenue" => $attributes['card_address_avenue']
                ]
            ],
            "client_ip" => $attributes['client_ip']
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'tokens', $postRequest);

        return $response->json();
    }

    /**
     * Create a token (Encrypted Card).
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createTokenEncryptedCard(array $attributes)
    {
        $postRequest = [
            "card" => [
                "address_city" => $attributes['card_address_city'],
                "address_country" => $attributes['card_address_country'],
                "address_line1" => $attributes['card_address_line1'],
                "address_line2" => $attributes['card_address_line2'],
                "address_state" => $attributes['card_address_state'],
                "address_zip" => $attributes['card_address_zip'],
                "crypted_data" => $attributes['card_crypted_data']
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'tokens', $postRequest);

        return $response->json();
    }

    /**
     * Create a token (Saved card).
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createTokenSavedCard(array $attributes)
    {
        $postRequest = [
            "saved_card" => [
                "card_id" => $attributes['saved_card_id'],
                "customer_id" => $attributes['saved_card_customer_id']
            ],
            "client_ip" => $attributes['client_ip']
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'tokens', $postRequest);

        return $response->json();
    }

    /**
     * Create a Token (ApplyPay Token).
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createTokenApplePay(array $attributes)
    {
        $postRequest = [
            "type" => "applepay",
            "token_data" => [
                "data" => $attributes['token_data'],
                "header" => [
                    "ephemeralPublicKey" => $attributes['token_data_header_ephemeralPublicKey'],
                    "publicKeyHash" => $attributes['token_data_header_publicKeyHash'],
                    "transactionId" => $attributes['token_data_header_transactionId']
                ],
                "signature" => $attributes['token_data_signature'],
                "version" => $attributes['token_data_version']
            ],
            "client_ip" => $attributes['client_ip']
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'tokens', $postRequest);

        return $response->json();
    }
}