<?php

namespace Anosmx\TapPayment;

use Illuminate\Support\Facades\Http;

class Recurring extends TapPayment
{
    /**
     * List recurring.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function listRecurring(array $attributes)
    {
        $postRequest = [
            "status" => $attributes['status'],
            "customers" => $attributes['customers'],
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
            ->post($this->endpoint . 'recurring/list', $postRequest);

        return $response->json();
    }

    public function createRecurring(array $attributes)
    {
        $postRequest = [
            "auto_renew" => $attributes['auto_renew'] ?? false,
            "term" => [
                "from" => $attributes['term_from'],
                "to" => $attributes['term_to'],
                "interval" => [
                    "period" => $attributes['term_interval_period'] ?? 'DAY',
                    "value" => $attributes['term_interval_value']
                ],
                "weekday" => $attributes['term_weekday'] ?? "SUNDAY"
            ],
            "due" => [
                "period" => $attributes['due_period'] ?? "DAY",
                "value" => $attributes['due_value']
            ],
            "expiry" => [
                "period" => $attributes['expiry_period'] ?? "DAY",
                "value" => $attributes['expiry_value']
            ],
            "grace" => [
                "period" => $attributes['grace_period'] ?? "DAY",
                "value" => $attributes['grace_value']
            ],
            "penalty" => [
                "amount" => $attributes['penalty_amount'] ?? 0,
                "type" => $attributes['penalty_type'] ?? "F"
            ],
            "invoice" => [
                "charge" => [
                    "receipt" => [
                        "email" => $attributes['invoice_charge_receipt_email'] ?? $this->receipt_by_email,
                        "sms" => $attributes['invoice_charge_receipt_sms'] ?? $this->receipt_by_sms
                    ],
                    "statement_descriptor" => $attributes['invoice_statement_descriptor']
                ],
                "currencies" => [
                    $attributes['currency'] ?? $this->currency
                ],
                "customer" => [
                    "email" => $attributes['customer_email'],
                    "first_name" => $attributes['customer_first_name'],
                    "last_name" => $attributes['customer_last_name'],
                    "middle_name" => $attributes['customer_middle_name'],
                    "phone" => [
                        "country_code" => $attributes['phone_country_code'] ?? $this->country_code,
                        "number" => $attributes['phone_number']
                    ]
                ],
                "description" => $attributes['description'],
                "invoicer" => [
                    "bcc" => $attributes['invoicer_bcc'],
                    "cc" => $attributes['invoicer_cc'],
                    "to" => $attributes['invoicer_to']
                ],
                "metadata" => [
                    "additionalProp1" => $attributes['metadata_additionalProp1'],
                    "additionalProp2" => $attributes['metadata_additionalProp2'],
                    "additionalProp3" => $attributes['metadata_additionalProp3']
                ],
                "mode" => $attributes['mode'] ?? "INVOICE",
                "note" => $attributes['note'],
                "notifications" => [
                    "channels" => $attributes['notifications_channels'] ?? ["EMAIL", "SMS"],
                    "dispatch" => $attributes['notifications_dispatch'] ?? true
                ],
                "order" => $attributes['order'] ?? [],
                "payment_methods" => [
                    $attributes['payment_methods']
                ],
                "post" => [
                    "url" => $attributes['post_url'] ?? $this->post_url
                ],
                "redirect" => [
                    "url" => $attributes['redirect_url'] ?? $this->redirect_url
                ],
                "reference" => [
                    "documents" => [
                        [
                            "images" => [
                                ""
                            ],
                            "number" => "",
                            "type" => ""
                        ]
                    ],
                    "invoice" => $attributes['invoice'],
                    "order" => $attributes['order']
                ]
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'recurring', $postRequest);

        return $response->json();
    }

    /**
     * Retrieve recurring.
     *
     * @param $recurring_id
     * @return array|mixed
     */
    public function retrieveRecurring($recurring_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'recurring/' . $recurring_id);

        return $response->json();
    }

    /**
     * Update recurring.
     *
     * @param $recurring_id
     * @param array $attributes
     * @return array|mixed
     */
    public function updateRecurring($recurring_id, array $attributes)
    {
        $putRequest = [
            "auto_renew" => $attributes['auto_renew'] ?? false,
            "term" => [
                "from" => $attributes['term_from'],
                "to" => $attributes['term_to'],
                "interval" => [
                    "period" => $attributes['term_interval_period'] ?? 'DAY',
                    "value" => $attributes['term_interval_value']
                ],
                "weekday" => $attributes['term_weekday'] ?? "SUNDAY"
            ],
            "due" => [
                "period" => $attributes['due_period'] ?? "DAY",
                "value" => $attributes['due_value']
            ],
            "expiry" => [
                "period" => $attributes['expiry_period'] ?? "DAY",
                "value" => $attributes['expiry_value']
            ],
            "grace" => [
                "period" => $attributes['grace_period'] ?? "DAY",
                "value" => $attributes['grace_value']
            ],
            "penalty" => [
                "amount" => $attributes['penalty_amount'] ?? 0,
                "type" => $attributes['penalty_type'] ?? "F"
            ],
            "invoice" => [
                "charge" => [
                    "receipt" => [
                        "email" => $attributes['invoice_charge_receipt_email'] ?? $this->receipt_by_email,
                        "sms" => $attributes['invoice_charge_receipt_sms'] ?? $this->receipt_by_sms
                    ],
                    "statement_descriptor" => $attributes['invoice_statement_descriptor']
                ],
                "currencies" => [
                    $attributes['currency'] ?? $this->currency
                ],
                "customer" => [
                    "email" => $attributes['customer_email'],
                    "first_name" => $attributes['customer_first_name'],
                    "last_name" => $attributes['customer_last_name'],
                    "middle_name" => $attributes['customer_middle_name'],
                    "phone" => [
                        "country_code" => $attributes['phone_country_code'] ?? $this->country_code,
                        "number" => $attributes['phone_number']
                    ]
                ],
                "description" => $attributes['description'],
                "invoicer" => [
                    "bcc" => $attributes['invoicer_bcc'],
                    "cc" => $attributes['invoicer_cc'],
                    "to" => $attributes['invoicer_to']
                ],
                "metadata" => [
                    "additionalProp1" => $attributes['metadata_additionalProp1'],
                    "additionalProp2" => $attributes['metadata_additionalProp2'],
                    "additionalProp3" => $attributes['metadata_additionalProp3']
                ],
                "mode" => $attributes['mode'] ?? "INVOICE",
                "note" => $attributes['note'],
                "notifications" => [
                    "channels" => $attributes['notifications_channels'] ?? ["EMAIL", "SMS"],
                    "dispatch" => $attributes['notifications_dispatch'] ?? true
                ],
                "order" => $attributes['order'] ?? [],
                "payment_methods" => [
                    $attributes['payment_methods']
                ],
                "post" => [
                    "url" => $attributes['post_url'] ?? $this->post_url
                ],
                "redirect" => [
                    "url" => $attributes['redirect_url'] ?? $this->redirect_url
                ],
                "reference" => [
                    "documents" => [
                        [
                            "images" => [
                                ""
                            ],
                            "number" => "",
                            "type" => ""
                        ]
                    ],
                    "invoice" => $attributes['invoice'],
                    "order" => $attributes['order']
                ]
            ]
        ];

        $response = Http::withToken($this->api_token)
            ->put($this->endpoint . 'recurring/' . $recurring_id, $putRequest);

        return $response->json();
    }

    /**
     * Cancel a recurring.
     *
     * @param $recurring_id
     * @return array|mixed
     */
    public function cancelRecurring($recurring_id)
    {
        $response = Http::withToken($this->api_token)
            ->delete($this->endpoint . 'recurring/' . $recurring_id);

        return $response->json();
    }
}