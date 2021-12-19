<?php
return [
    'api_token'         => env('TAP_API_TOKEN', ''),
    'currency'          => env('TAP_CURRENCY', 'SAR'),
    'timezone'          => env('TAP_TIMEZONE', config('app.timezone')),
    'receipt_by_email'  => env('TAP_RECEIPT_BY_EMAIL', false),
    'receipt_by_sms'    => env('TAP_RECEIPT_BY_SMS', false),
    'country_code'      => env('TAP_COUNTRY_CODE', '966'),
    'post_url'          => env('TAP_POST_URL', 'http://localhost'),
    'redirect_url'      => env('TAP_REDIRECT_URL', 'http://localhost'),
    'lang_code'         => env('TAP_LANG_CODE', 'ar'),
];