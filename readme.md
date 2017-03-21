# Laravel verification tokens

A library to easily generate a token, for use in e-mail for instance, and automatically
process callbacks.


### Installation

```bash
composer require gravure/laravel-verification-tokens
```

Register the service provider in your `config/app.php`:

```php
    // Gravure verification token routes
    Gravure\Verification\Providers\RouteProvider::class,
```

> The route provider register the callback handler, the route is named: `verification.callback`.
Feel free to implement your own provider and/or route.
