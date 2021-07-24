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

Don't forget to run ```php artisan config:clear```

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
### [Users](https://odkcentral.docs.apiary.io/#reference/accounts-and-users/users)

```php
// Get all users.
$users = $odk->users()->get();

// Searching users
$users = $odk->users('Jane')->get();

// You can also use eloquent 💥
$users = $odk->users()->get()->sortBy('displayName');

// Creating a new user.
$newUser = $odk->users()->create([
  'email' => 'example@email.com',
  'password' => 'password' // Optional (That email address will receive a message instructing the new user on how to claim their new account and set a password.)
]);

// Getting User details
$user = $odk->users($userId)->get();

// Getting authenticated User details
$user = $odk->users()->current();

// Modifying a User
$user = $odk->users($userId)->update([
  'displayName' => 'New name', // string
  'email' => 'new.email.address@demo.org' // string
]);

// Directly updating a user password
$user = $odk->users($userId)->updatePassword([
  'old' => 'old.password', // string
  'new' => 'new.password' // string
]);

// Initiating a password reset
$user = $odk->users()->passwordReset($userEmail);

// Deleting a User
$user = $odk->users($userId)->delete();

```


### [App Users](https://odkcentral.docs.apiary.io/#reference/accounts-and-users/app-users)

```php
// Listing all App Users.
$appUsers = $odk->projects($projectId)->appUsers()->get();

// Creating a new App User.
$newAppUser = $odk->projects($projectId)->appUsers()->create([
  'displayName' => 'Jane Doe'
]);

// Deleting a App User
$appUser = $odk->projects($projectId)->appUsers($appUserId)->delete();

```

### [Projects](https://odkcentral.docs.apiary.io/#reference/project-management)

```php
// Get a list of projects.
$projects = $odk->projects()->get();

// Creating a Project.
$project = $odk->projects()->create([
  'name' => 'My new project'
]);

// Getting Project details
$project = $odk->projects($projectId)->get();

// Updating Project Details
$project = $odk->projects($projectId)->update([
  'name' => 'New name', // string | required
  'archived' => false // boolean | optional
]);

// Deep Updating Project and Form Details
$project = $odk->projects($projectId)->deepUpdate([
  'name' => 'New name', // string | required
  'archived' => false, // boolean | optional
  'forms' => [
    {
      "xmlFormId": "simple",
      "state": "open",
      "assignments": [
        {
          "roleId": 2,
          "actorId": 14
        }
      ]
    }
  ], // array | infos : https://odkcentral.docs.apiary.io/#reference/project-management/projects/deep-updating-project-and-form-details
]);

// Enabling Project Managed Encryption
$project = $odk->projects($projectId)->encrypt([
  'passphrase' => 'Super duper secret', // string | required
  'hint' => 'My reminder' // string | optional
]);

// Deleting a Project
$project = $odk->projects($projectId)->delete();

```

### [Forms](https://odkcentral.docs.apiary.io/#reference/forms)

```php
// Get a list of forms from a project.
$forms = $odk->forms($projectId);
```

### [Submissions](https://odkcentral.docs.apiary.io/#reference/submissions)

```php
// Get a list of projects.
$submissions = $odk->submissions();
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
