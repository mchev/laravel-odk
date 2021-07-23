# Laravel ODK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mchev/laravel-odk.svg?style=flat-square)](https://packagist.org/packages/mchev/laravel-odk)
[![Total Downloads](https://img.shields.io/packagist/dt/mchev/laravel-odk.svg?style=flat-square)](https://packagist.org/packages/mchev/laravel-odk)
![GitHub Actions](https://github.com/mchev/laravel-odk/actions/workflows/main.yml/badge.svg)

Laravel-ODK is a simple wrapper around the ODK Central API that makes working with its endpoints a breeze! 

## Installation

You can install the package via composer:

```bash
composer require mchev/laravel-odk
```

Then publish the config
```bash
php artisan vendor:publish --provider="Mchev\LaravelOdk\Providers\OdkCentralServiceProvider" --tag=config
```

Finally, add following lines to the .env file 
```
ODK_API_URL="https://private-anon-cecdde38ec-odkcentral.apiary-mock.com/v1"
ODK_USER_EMAIL=your_email
ODK_USER_PASSWORD=your_password
```

## Usage

```php
use Mchev\LaravelOdk\OdkCentral;

class OdkController
{
  
  public function getUsers()
  {
  
    $odk = new OdkCentral();
    
    $users = $odk->users();
    
    return response()->json($users);
    
  }

}

```
### Users

```php
// Get all users.
$users = $odk->users();

// Searching users
$users = $odk->users('Jane');

// You can also use eloquent :boom:
$users = $odk->users()->sortBy('displayName');

// Creating a new user.
$newUser = $odk->user()->create([
  'email' => 'example@email.com',
  'password' => 'password' // Optional (That email address will receive a message instructing the new user on how to claim their new account and set a password.)
]);

// Getting User details
$user = $odk->user()->find($userId);

// Getting authenticated User details
$user = $odk->user()->current();

// Modifying a User
$user = $odk->user()->update([
  'userId' => 42, // integer
  'displayName' => 'New name', // string
  'email' => 'new.email.address@demo.org' // string
]);

// Directly updating a user password
$user = $odk->user()->updatePassword([
  'userId' => 42, // integer
  'old' => 'old.password', // string
  'new' => 'new.password' // string
]);

// Initiating a password reset
$user = $odk->user()->passwordReset($userEmail);

// Deleting a User
$user = $odk->user()->delete($userId);

```

### Projects

```php
// Get a list of projects.
OdkCentral::projects()->get();
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email martin.chevignard@gmail.com instead of using the issue tracker.

## Credits

-   [Martin Chevignard](https://github.com/mchev)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
