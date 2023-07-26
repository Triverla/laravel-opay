# laravel-opay
A Laravel package to seamlessly integrate Opay payment APIs to any new or existing laravel application.

[Link to Opay documentation](https://documentation.opayweb.com)

## Installation

[PHP](https://php.net) 7.2+ or [HHVM](http://hhvm.com) 3.3+, and [Composer](https://getcomposer.org) are required.

To get the latest version of Laravel Opay, simply require it

```bash
composer require triverla/laravel-opay
```

Or add the following line to the require block of your `composer.json` file.

```
"triverla/laravel-opay": "1.0.*"
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.



Once Laravel Opay is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

```php
'providers' => [
    ...
    Triverla\LaravelOpay\OpayServiceProvider::class,
    ...
]
```

> If you use **Laravel >= 5.5** you can skip this step and go to [**`configuration`**](https://github.com/triverla/laravel-opay#configuration)

* `Triverla\LaravelOpay\OpayServiceProvider::class`

Also, register the Facade like so:

```php
'aliases' => [
    ...
    'Opay' => Triverla\LaravelOPay\Facades\Opay::class,
    ...
]
```

## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Triverla\LaravelOpay\OpayServiceProvider"
```
A configuration file `opay.php` with some sensible defaults will be placed in your `config` directory as displayed below:

```php
<?php

return [

     'base_url' => env('OPAY_BASE_URL', 'https://cashierapi.opayweb.com'),
     
     'secret_key' => env('OPAY_SECRET_KEY', ''),
    
     'public_key' => env('OPAY_PUBLIC_KEY', ''),
    
     'merchant_id' => env('OPAY_MERCHANT_ID', '')

];
```

## Usage

Open your .env file and add the following keys. You can get them at ([https://merchant.opaycheckout.com/account-details](https://merchant.opaycheckout.com/account-details)) Under the API keys & Webhook tab:

```php
OPAY_BASE_URL=https://cashierapi.opayweb.com
OPAY_SECRET_KEY=XXXXXXXXXX
OPAY_PUBLIC_KEY=XXXXXXXXXX
OPAY_MERCHANT_ID=XXXXXXXXXX
```

- import the Opay Facades with the import statement below;
- Also import the FailedRequestException that handles the exceptions thrown from failed requests. This exception returns the corresponding Opay error message and code


```php
    ...
    
    use Triverla\LaravelOpay\Facades\Opay;
    use Triverla\LaravelOpay\Exceptions\FailedRequestException;
    
    ...
```

Other methods include
```php

    use Triverla\LaravelOpay\Facades\Opay;
    
    //Bank Endpoints
    $response = Opay::bank()->countries();
    $response = Opay::bank()->banks();
    
    //Wallet
     $response = Opay::wallet()->initiateTransaction(string $reference, string $userPhone, float $amount, string $userRequestIp, string $productName, string $productDesc, int $expiresAt = 30, string $currency = 'NGN');
     $response = Opay::wallet()->authorizeTransaction(string $reference, string $orderNo, string $userPhone, string $pin);
     $response = Opay::wallet()->sendOTP(string $reference, string $orderNo, string $payMethod);
     $response = Opay::wallet()->verifyOTP(string $reference, string $orderNo, string $payMethod, string $otp);
     $response = Opay::wallet()->closeTransaction(string $reference, string $orderNo);
     $response = Opay::wallet()->initializeRefund(string $reference, string $refundReference, float $refundAmount, string $orderNo, string $currency = 'NGN');
     $response = Opay::wallet()->verifyRefundStatus(string $reference, string $refundReference, float $refundAmount, string $refundOrderNo);
     
     //Account
     $response = Opay::account()->createUserAccount(string $phoneNumber, string $email, string $firstName, string $lastName, string $password, string $address, string $otp);
     $response = Opay::account()->sendOTP(string $phoneNumber);
     
     //Inquiry
     $response = Opay::inquiry()->balance();
     $response = Opay::inquiry()->validateOPayUser(string $phoneNumber);
     $response = Opay::inquiry()->validateOPayMerchant(string $email);
     $response = Opay::inquiry()->validateBankAccountNumber(string $bankCode, string $bankAccountNumber, string $countryCode = 'NG');
     
     //Transfer
      $response = Opay::transfer()->opayWallet(WalletTransferPayload $payload);
      $response = Opay::transfer()->queryWalletTransferStatus(string $reference, string $orderNo);
      $response = Opay::transfer()->opayWalletBatch(WalletTransferPayloadList $payloadList);
      $response = Opay::transfer()->bankAccount(BankTransferPayload $payload);
      $response = Opay::transfer()->queryBankTransferStatus(string $reference, string $orderNo);
      $response = Opay::transfer()->bankAccountBatch(BankTransferPayloadList $payloadList);
      
      //Transactions
      $response = Opay::transaction()->initializeCardTransaction(string $reference, float $amount, string $firstName, string $lastName, string $customerEmail, string $cardNumber,
                                              string $cardDateMonth, string $cardDateYear, string $cardCVC, string $return3dsUrl, string $bankAccountNumber,
                                              string $bankCode, string $reason, string $callbackUrl, string $expiresAt, string $billingZip = null, string $billingCity = null,
                                              string $billingAddress = null, string $billingState = null, string $billingCountry = null,
                                              string $currency = 'NGN', string $country = 'NG');
                                              
     $response = Opay::transaction()->initializeTokenTransaction(string $reference, float $amount, string $customerPhone, string $customerEmail, string $reason, string $callbackUrl, string $expiresAt, string $token,
                                               string $currency = 'NGN', string $country = 'NG');
    
    $response = Opay::transaction()->initializeBankAccountTransaction(string $reference, float $amount, string $customerPhone, string $return3dsUrl, string $bankAccountNumber,
                                                     string $bankCode, string $reason, string $bvn, string $dobDay, string $dobMonth, string $dobYear,
                                                     string $currency = 'NGN', string $country = 'NG');
                                                     
    $response = Opay::transaction()->checkTransactionStatus(string $reference, string $orderNo);
    $response = Opay::transaction()->transactionInputPIN(string $reference, string $orderNo, string $pin);
    $response = Opay::transaction()->transactionInputOTP(string $reference, string $orderNo, string $otp);
    $response = Opay::transaction()->transactionInputPhone(string $reference, string $orderNo, string $phone);
    $response = Opay::transaction()->transactionInputDob(string $reference, string $orderNo, string $dob);
    $response = Opay::transaction()->initiateBankTransferTransaction(string $reference, string $userPhone, float $amount, string $userRequestIp, string $productName, string $productDesc, int $expiresAt = 30, string $currency = 'NGN');
    $response = Opay::transaction()->getBankTransferTransactionStatus(string $reference, string $orderNo);
    $response = Opay::transaction()->initiateUSSDTransaction(string $reference, string $userPhone, float $amount, string $userRequestIp, string $productName, string $productDesc, int $expiresAt = 30, string $currency = 'NGN');
    $response = Opay::transaction()->getUSSDTransactionStatus(string $reference, string $orderNo);

    //Bills
    $response = Opay::bills()->bettingProviders();
    $response = Opay::bills()->validate(string $serviceType, string $provider, string $customerId);
    $response = Opay::bills()->bulkBills(BulkBillsListPayload $billsListPayload, string $callbackUrl, string $serviceType);
    $response = Opay::bills()->bulkStatus(BulkStatusRequest $bulkStatusRequest, string $serviceType);
```


### Testing

``` bash
composer test
```

### Todo

* Webhook Events

### Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance the functionalities.

### Bugs & Issues

If you notice any bug or issues with this package kindly create and issues here [ISSUES](https://github.com/triverla/laravel-opay/issues)

### Security

If you discover any security related issues, please email yusufbenaiah@gmail.com.

## How can I thank you?

Why not star the github repo and share the link for this repository on Twitter or other social platforms.

Don't forget to [follow me on twitter](https://twitter.com/benaiah_yusuf)!

Thanks!
Benaiah Yusuf

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
