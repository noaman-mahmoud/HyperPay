# integration payment with hyperpay

## Installation

You can install the package via [Composer](https://getcomposer.org).

```bash
composer require noaman-mahmoud/hyperpay
```
## Publishing

After install publish file config

```bash
php artisan vendor:publish --tag="hyperpay"
```

## Usage

```php
use NoamanMahmoud\HyperPay\HyperPay;

// price = 100 ;  brand = mada ; information = [ config.information ] 
HyperPay::checkoutHyperPay(100,'mada');  

// get transaction Id
$transactionId = HyperPay::transactionId();

return view('hyperpay_form', compact('transactionId'));

// Example view 
<form action="{{url('check-payment')}}" class="paymentWidgets"  data-brands="MADA"></form>

<script>
    var wpwlOptions = {
        style: "card",
        locale: "ar",
        paymentTarget:'_top'
    }
</script>

<script async src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$transactionId}}"></script>

// after submit form check status $request->id

// brand = mada
$status = HyperPay::paymentStatus($request->id,'mada');

// success
$status = ['status' => 'success' , 'description'=> ''];

// fail
$status = ['status' => 'fail' , 'description'=> ''];

```

## Config file hyperpay.php 

```php
// you can change mode  
 "mode" => env( 'HYPER_PAY_MODE', "test" ),
```

## Brands :
- VISA
- MASTER
- VISA MASTER 
- AMEX
- APPLEPAY
- MADA
- .... etc

## Testing Cards

4111111111111111 05/22 cvv2 123 (Success).

5204730000002514 05/22 cvv2 251 (Fail).

Mada test card :
5297412484442387 10/22 cvv2 966




