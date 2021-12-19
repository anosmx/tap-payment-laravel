# Tap Payment Gateway Wrapper for Laravel

This package provides an easy way to interact with Tap Payment https://tap.company. 

## Laravel compatibility

| Laravel                        | PHP   |
|:-------------------------------|:------|
| ^8.0                           | 8.0   |

## Installation
Use the package manager composer to install.
```bash
composer require anosmx/tap-payment-laravel
```

### Publish configuration file.
```bash
php artisan vendor:publish --tag=tap-payment-config
```
#### Available variables
```dotenv
TAP_API_TOKEN={Your Tap Payment Token}
TAP_CURRENCY='SAR'
TAP_TIMEZONE='Asia/Riyadh'
TAP_RECEIPT_BY_EMAIL=false
TAP_RECEIPT_BY_SMS=false
TAP_COUNTRY_CODE='966'
TAP_POST_URL='http://localhost'
TAP_REDIRECT_URL='http://localhost'
TAP_LANG_CODE='ar'
```


## Usage
### Available classes:
```
Authorize
Card
Charge
Customer
Invoice
Order
Product
Recurring
Refund
Subscription
Token
```

### Example class usage:
#### Access the class using Facade.
```php
use Anosmx\TapPayment\Facades\TapCharge;

$attributes = [
    'period_date_from'  => 1516315144000,
    'period_date_to'    => 1545172744000,
    'period_type'       => 1,
    'status'            => '',
    'starting_after'    => '',
    'limit'             => 25
];

$charges = TapCharge::listCharges($attributes);
```
#### Or directly
```php
use Anosmx\TapPayment\Authorize;

$authorize = new Authorize();
$authorize->updateAuthorize($authorize_id, [
    'description'   => 'Foo',
    'receipt_email' => true,
    'receipt_sms'   => false,
    'metadata_udf2' => 'Bar'
]);
```

Available attributes can be found in each class function. ex:
```php
Anosmx\TapPayment\{ClassName}
```

# License
The MIT License (MIT).