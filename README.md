# laravel-opay

## Installation

[PHP](https://php.net) 5.4+ or [HHVM](http://hhvm.com) 3.3+, and [Composer](https://getcomposer.org) are required.

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
