<?php

namespace Anosmx\TapPayment;

use Illuminate\Support\Facades\Http;

class Product extends TapPayment
{
    /**
     * List all products.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function listProduct(array $attributes)
    {
        $postRequest = [
            "period" => [
                "date" => [
                    "from" => $attributes['period_date_from'] ?? '',
                    "to" => $attributes['period_date_to'] ?? ''
                ]
            ],
            "starting_after" => $attributes['starting_after'] ?? '',
            "limit" => $attributes['limit'] ?? ''
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'products/list', $postRequest);

        return $response;
    }

    /**
     * Create a product
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createProduct(array $attributes)
    {
        $postRequest = [
            "amount" => $attributes['amount'] ?? '',
            "currency" => $this->currency,
            "description" => $attributes['description'] ?? '',
            "discount" => [
                "type" => $attributes['discount_type'] ?? '',
                "value" => $attributes['discount_value'] ?? ''
            ],
            "image" => $attributes['image'] ?? '',
            "name" => $attributes['name'] ?? '',
            "quantity" => $attributes['quantity'] ?? ''
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'products', $postRequest);

        return $response;
    }

    /**
     * Retrieve product.
     *
     * @param $product_id
     * @return array|mixed
     */
    public function retrieveProduct($product_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'products/' . $product_id);

        return $response;
    }

    /**
     * Update a product.
     *
     * @param $product_id
     * @param array $attributes
     * @return array|mixed
     */
    public function updateProduct($product_id, array $attributes)
    {
        $putRequest = [
            "amount" => $attributes['amount'] ?? '',
            "currency" => $this->currency,
            "description" => $attributes['description'] ?? '',
            "discount" => [
                "type" => $attributes['discount_type'] ?? '',
                "value" => $attributes['discount_value'] ?? ''
            ],
            "image" => $attributes['image'] ?? '',
            "name" => $attributes['name'] ?? '',
            "quantity" => $attributes['quantity'] ?? ''
        ];

        $response = Http::withToken($this->api_token)
            ->put($this->endpoint . 'products/' . $product_id, $putRequest);

        return $response;
    }

    /**
     * Delete a product.
     *
     * @param $product_id
     * @return array|mixed
     */
    public function deleteProduct($product_id)
    {
        $response = Http::withToken($this->api_token)
            ->delete($this->endpoint . 'products/' . $product_id);

        return $response;
    }
}