<?php

namespace Anosmx\TapPayment;

use Illuminate\Support\Facades\Http;

class Order extends TapPayment
{
    /**
     * List all orders.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function listOrders(array $attributes)
    {
        $postRequest = [
            "status" => $attributes['status'],
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
            ->post($this->endpoint . 'orders/list', $postRequest);

        return $response->json();
    }

    /**
     * Create an order.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createProduct(array $attributes)
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
            ],

            "items" => [
                [
                    "name" => [
                        "en" => "test"
                    ],
                    "description" => [
                        "en" => "test"
                    ],
                    "image" => "",
                    "currency" => "KWD",
                    "amount" => 1,
                    "quantity" => "1",
                    "discount" => [
                        "type" => "P",
                        "value" => 0
                    ]
                ]
            ],
            "tax" => [
                [
                    "description" => "test",
                    "name" => "VAT",
                    "rate" => [
                        "type" => "F",
                        "value" => 1
                    ]
                ]
            ],
            "shipping" => [
                "amount" => 1,
                "currency" => "KWD",
                "description" => [
                    "en" => "test"
                ],
                "address" => [
                    "recipient_name" => "test",
                    "line1" => "sdfghjk",
                    "line2" => "oiuytr",
                    "district" => "hawally",
                    "city" => "hawally",
                    "state" => "hw",
                    "zip_code" => "30003",
                    "po_box" => "200021",
                    "country" => "kuwait"
                ]
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'orders', $postRequest);

        return $response->json();
    }

    /**
     * Retrieve order.
     *
     * @param $order_id
     * @return array|mixed
     */
    public function retrieveOrder($order_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'orders/' . $order_id);

        return $response->json();
    }

    /**
     * Update an order.
     *
     * @param $order_id
     * @param array $attributes
     * @return array|mixed
     */
    public function updateOrder($order_id, array $attributes)
    {
        $putRequest = [
            "amount" => $attributes['amount'],
            "currency" => $attributes['currency'] ?? $this->currency,
            "items" => [
                [
                    "amount" => 10,
                    "currency" => $this->currency,
                    "description" => "test",
                    "discount" => [
                        "type" => "P",
                        "value" => 0
                    ],
                    "image" => "",
                    "name" => "test",
                    "quantity" => 1
                ]
            ],
            "shipping" => [
                "amount" => 1,
                "currency" => $this->currency,
                "description" => "test",
                "provider" => "ARAMEX",
                "service" => "test"
            ],
            "tax" => [
                [
                    "description" => "test",
                    "name" => "VAT",
                    "rate" => [
                        "type" => "F",
                        "value" => 1
                    ]
                ]
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->put($this->endpoint . 'orders/' . $order_id, $putRequest);

        return $response->json();
    }

    /**
     * Cancel an order.
     *
     * @param $order_id
     * @return array|mixed
     */
    public function cancelOrder($order_id)
    {
        $response = Http::withToken($this->api_token)
            ->delete($this->endpoint . 'orders/' . $order_id);

        return $response->json();
    }
}