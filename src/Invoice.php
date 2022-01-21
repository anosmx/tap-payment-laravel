<?php

namespace Anosmx\TapPayment;

use Illuminate\Support\Facades\Http;

class Invoice extends TapPayment
{
    public function listInvoices(array $attributes)
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
            "limit" => $attributes['limit']
        ];

        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'invoices/list', $postRequest);

        return $response;
    }

    /**
     * Create an invoice.
     *
     * @param array $attributes
     * @return array|mixed
     */
    public function createInvoice(array $attributes)
    {
        $postRequest = [
            "draft" => $attributes['draft'] ?? false,
            "due" => $attributes['due'],
            "expiry" => $attributes['due'],
            "description" => $attributes['description'],
            "mode" => $attributes['mode'],
            "note" => $attributes['note'],
            "notifications" => [
                "channels" => $attributes['notifications_channels'] ?? ["SMS", "EMAIL"],
                "dispatch" => $attributes['notifications_dispatch'] ?? true
            ],
            "currencies" => $attributes['currencies'] ?? ["$this->currency"],
            "metadata" => [
                "udf1" => $attributes['metadata_udf1'],
                "udf2" => $attributes['metadata_udf2'],
                "udf3" => $attributes['metadata_udf3']
            ],
            "charge" => [
                "receipt" => [
                    "email" => $attributes['charge_receipt_email'] ?? $this->receipt_by_email,
                    "sms" => $attributes['charge_receipt_sms'] ?? $this->receipt_by_sms
                ],
                "statement_descriptor" => $attributes['statement_descriptor']
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
            "order" => [
                "amount" => $attributes['order_amount'],
                "currency" => $attributes['order_currency'] ?? $this->currency,
                "items" => $attributes['order_items'],
                "shipping" => $attributes['order_shipping'],
                "tax" => $attributes['order_tax']
            ],
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
                "invoice" => $attributes['reference_invoice'],
                "order" => $attributes['reference_order']
            ]
        ];

        $response = Http::withToken($this->api_token)->withHeaders([
            'lang_code' => $this->lang_code ?? 'ar'
        ])
            ->post($this->endpoint . 'invoices', $postRequest);

        return $response;
    }

    /**
     * Retrieve an invoice.
     *
     * @param $invoice_id
     * @return array|mixed
     */
    public function retrieveInvoice($invoice_id)
    {
        $response = Http::withToken($this->api_token)
            ->get($this->endpoint . 'invoices/' . $invoice_id);

        return $response;
    }

    /**
     * Update an invoice.
     *
     * @param $invoice_id
     * @param array $attributes
     * @return array|mixed
     */
    public function updateInvoice($invoice_id, array $attributes)
    {
        $putRequest = [
            "draft" => $attributes['draft'] ?? false,
            "due" => $attributes['due'],
            "expiry" => $attributes['due'],
            "description" => $attributes['description'],
            "mode" => $attributes['mode'],
            "note" => $attributes['note'],
            "notifications" => [
                "channels" => $attributes['notifications_channels'] ?? ["SMS", "EMAIL"],
                "dispatch" => $attributes['notifications_dispatch'] ?? true
            ],
            "currencies" => $attributes['currencies'] ?? ["$this->currency"],
            "metadata" => [
                "udf1" => $attributes['metadata_udf1'],
                "udf2" => $attributes['metadata_udf2'],
                "udf3" => $attributes['metadata_udf3']
            ],
            "charge" => [
                "receipt" => [
                    "email" => $attributes['charge_receipt_email'] ?? $this->receipt_by_email,
                    "sms" => $attributes['charge_receipt_sms'] ?? $this->receipt_by_sms
                ],
                "statement_descriptor" => $attributes['statement_descriptor']
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
            "order" => [
                "amount" => $attributes['order_amount'],
                "currency" => $attributes['order_currency'] ?? $this->currency,
                "items" => $attributes['order_items'],
                "shipping" => $attributes['order_shipping'],
                "tax" => $attributes['order_tax']
            ],
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
                "invoice" => $attributes['reference_invoice'],
                "order" => $attributes['reference_order']
            ],
            "invoicer" => [
                "to" => $attributes['invoicer_to'],
                "cc" => $attributes['invoicer_cc'],
                "bcc" => $attributes['invoicer_bcc']
            ]

        ];

        $response = Http::withToken($this->api_token)
            ->put($this->endpoint . 'invoices/' . $invoice_id, $putRequest);

        return $response;
    }

    /**
     * Finalize an invoice.
     *
     * @param $invoice_id
     * @return array|mixed
     */
    public function finalizeInvoice($invoice_id)
    {
        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'invoices/' . $invoice_id . '/finalize');

        return $response;
    }

    /**
     * Remind invoice.
     *
     * @param $invoice_id
     * @return array|mixed
     */
    public function remindInvoice($invoice_id)
    {
        $response = Http::withToken($this->api_token)
            ->post($this->endpoint . 'invoices/' . $invoice_id . '/remind');

        return $response;
    }

    /**
     * Cancel an invoice.
     *
     * @param $invoice_id
     * @return array|mixed
     */
    public function cancelInvoice($invoice_id)
    {
        $response = Http::withToken($this->api_token)
            ->delete($this->endpoint . 'invoices/' . $invoice_id);

        return $response;
    }
}