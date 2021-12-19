<?php

namespace Anosmx\TapPayment;

class TapPayment
{
    protected $api_token;
    protected $endpoint;
    protected $currency;
    protected $timezone;
    protected $receipt_by_email;
    protected $receipt_by_sms;
    protected $country_code;
    protected $post_url;
    protected $redirect_url;
    protected $lang_code;

    public function __construct()
    {
        $this->api_token        = config('tap_payment.api_token');
        $this->currency         = config('tap_payment.currency');
        $this->timezone         = config('tap_payment.timezone');
        $this->receipt_by_email = config('tap_payment.receipt_by_email');
        $this->receipt_by_sms   = config('tap_payment.receipt_by_sms');
        $this->country_code     = config('tap_payment.country_code');
        $this->post_url         = config('tap_payment.post_url');
        $this->redirect_url     = config('tap_payment.redirect_url');
        $this->lang_code        = config('tap_payment.lang_code');
        $this->endpoint         = "https://api.tap.company/v2/";
    }
}