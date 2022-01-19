<?php

namespace Anosmx\TapPayment;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Subscription extends TapPayment
{
    /**
     * List subscriptions.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function listSubscriptions(array $attributes)
    {
        $postRequest = [
            "period" => [
                "date" => [
                    "from" => $attributes['period_date_from'] ?? '',
                    "to" => $attributes['period_date_to'] ?? ''
                ]
            ],
            "customers" => $attributes['customers'],
            "cards" => $attributes['cards'],
            "subscriptions" => $attributes['subscriptions'] ?? '',
            "starting_after" => $attributes['starting_after'] ?? '',
            "limit" => $attributes['limit'] ?? ''
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'subscription/v1/list', $postRequest);

        return $response->json();
    }

    /**
     * Create a subscription.
     *
     * @param array $attributes
     * @return array|JsonResponse|mixed
     */
    public function createSubscription(array $attributes)
    {
        $postRequest = [
            "term" => [
                "interval" => $attributes['term_interval'],
                "period" => $attributes['term_period'],
                "from" => $attributes['term_from_datetime'],
                "due" => $attributes['term_due'],
                "auto_renew" => $attributes['term_auto_renew'],
                "timezone" => $this->timezone
            ],
            "trial" => [
                "days" => $attributes['trail_days'],
                "amount" => $attributes['trail_amount']
            ],
            "charge" => [
                "amount" => $attributes['charge_amount'],
                "currency" => $this->currency,
                "description" => $attributes['charge_description'],
                "statement_descriptor" => $attributes['charge_statement_descriptor'],
                "metadata" => $attributes['metadata'],
                "reference" => [
                    "transaction" => $attributes['reference_transaction'],
                    "order" => $attributes['reference_order']
                ],
                "receipt" => [
                    "email" => $attributes['receipt_email'] ?? $this->receipt_by_email,
                    "sms" => $attributes['receipt_sms'] ?? $this->receipt_by_sms
                ],
                "customer" => [
                    "id" => $attributes['charge_customer_id']
                ],
                "source" => [
                    "id" => $attributes['charge_source_id']
                ],
                "post" => [
                    "url" => $attributes['charge_post_url']
                ]
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'subscription/v1/', $postRequest);

        return $response->json();
    }

    /**
     * Retrieve subscription by ID.
     *
     * @param $subscription_id
     * @return array|mixed
     */
    public function getSubscription($subscription_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'subscription/v1/' . $subscription_id);

        return $response->json();
    }

    /**
     * Update subscription.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function updateSubscription($subscription_id, array $attributes)
    {
        $putRequest = [
            "subscription_id" => $subscription_id,
            "amount" => $attributes['amount'],
            "auto-renew" => $attributes['auto_renew'],
            "description" => $attributes['description'],
            "statement_descriptor" => $attributes['statement_descriptor'],
            "metadata" => $attributes['metadata'],
            "reference" => [
                "transaction" => $attributes['reference_transaction'],
                "order" => $attributes['reference_order']
            ],
            "receipt" => [
                "email" => $attributes['receipt_email'] ?? $this->receipt_by_email,
                "sms" => $attributes['receipt_sms'] ?? $this->receipt_by_sms
            ],
            "card_id" => $attributes['card_id'],
            "post" => [
                "url" => $attributes['post_url'] ?? $this->post_url
            ],
        ];

        $response = Http::withToken($this->api_token)
            ->put($this->endpoint . 'subscription/v1/', $putRequest);

        return $response->json();
    }

    /**
     * Cancel subscription.
     *
     * @param $subscription_id
     * @return array|mixed
     */
    public function cancelSubscription($subscription_id)
    {
        $response = Http::withToken($this->api_token)
            ->delete($this->endpoint . 'subscription/v1/' . $subscription_id);

        return $response->json();
    }
}