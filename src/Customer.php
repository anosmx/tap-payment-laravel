<?php

namespace Anosmx\TapPayment;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class Customer extends TapPayment
{
    /**
     * List all customers.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function listCustomers(array $attributes)
    {
        $postRequest = [
            "period" => [
                "date" => [
                    "from" => $attributes['period_date_from'],
                    "to" => $attributes['period_date_to']
                ],
            ],
            "starting_after" => $attributes['starting_after'],
            "limit" => $attributes['limit'],
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'customers/list', $postRequest);

        return $response->json();
    }

    /**
     * Create a customer.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createCustomer(array $attributes)
    {
        $postRequest = [
            "first_name" => $attributes['first_name'],
            "middle_name" => $attributes['middle_name'],
            "last_name" => $attributes['last_name'],
            "email" => $attributes['email'],
            "phone" => [
                "country_code" => $this->country_code,
                "number" => $attributes['phone_number']
            ],
            "description" => $attributes['description'],
            "metadata" => $attributes['metadata'],
            "currency" => $this->currency
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'customers', $postRequest);

        return $response->json();
    }

    /**
     * Retrieve a customer.
     *
     * @param $customer_id
     * @return array|mixed
     */
    public function retrieveCustomer($customer_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'customers/' . $customer_id);

        return $response->json();
    }

    /**
     * Update a customer
     *
     * @param $customer_id
     * @param array $attributes
     * @return array|mixed
     */
    public function updateCustomer($customer_id, array $attributes)
    {
        $putRequest = [
            "first_name" => $attributes['first_name'],
            "middle_name" => $attributes['middle_name'],
            "last_name" => $attributes['last_name'],
            "email" => $attributes['email'],
            "phone" => [
                "country_code" => $attributes['phone_country_code'] ?? $this->country_code,
                "number" => $attributes['phone_number']
            ],
            "description" => $attributes['description'],
            "metadata" => [
                "udf1" => $attributes['metadata_udf1']
            ],
            "currency" => $attributes['currency'] ?? $this->currency
        ];

        $response = Http::withToken($this->api_token)
            ->put($this->endpoint . 'customers/' . $customer_id, $putRequest);

        return $response->json();
    }

    /**
     * Delete a customer.
     *
     * @param $customer_id
     * @return array|mixed
     */
    public function deleteCustomer($customer_id)
    {
        $response = Http::withToken($this->api_token)
            ->delete($this->endpoint . 'customers/' . $customer_id);

        return $response->json();
    }
}