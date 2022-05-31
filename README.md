# Laravel ODK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mchev/laravel-odk.svg?style=flat-square)](https://packagist.org/packages/mchev/laravel-odk)
[![Total Downloads](https://img.shields.io/packagist/dt/mchev/laravel-odk.svg?style=flat-square)](https://packagist.org/packages/mchev/laravel-odk)
![GitHub Actions](https://github.com/mchev/laravel-odk/actions/workflows/main.yml/badge.svg)
![Laravel compatibility]([https://img.shields.io/badge/laravel-8%7C9-green](https://img.shields.io/badge/laravel-%5E8.0%7C%5E9.0-brightgreen)

Laravel-ODK is a simple wrapper around the ODK Central API that makes working with its endpoints a breeze! 
To get more informations about the API see [https://odkcentral.docs.apiary.io/](https://odkcentral.docs.apiary.io/#)

## Installation

You can install the package via composer:

```bash
composer require mchev/laravel-odk
```

## Configuration

Publish the config of the package.
```bash
php artisan vendor:publish --provider="Mchev\LaravelOdk\Providers\OdkCentralServiceProvider" --tag=config
```
The following config will be published to config/odkcentral.php.
```php
return [

    /*
    |--------------------------------------------------------------------------
    | ODK Central API url
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default url for the API calls.
    | Example : https://private-anon-cecdde38ec-odkcentral.apiary-mock.com/v1
    |
    */
    
    'api_url' => env('ODK_API_URL'),


    /*
    |--------------------------------------------------------------------------
    | ODK Central Authentification
    |--------------------------------------------------------------------------
    |
    | An administrator user of your ODK Central app.
    |
    */

    'user_email' => env('ODK_USER_EMAIL'),

    'user_password' => env('ODK_USER_PASSWORD'),


];
```

Set the ```ODK_API_URL```, ```ODK_USER_EMAIL``` and ```ODK_USER_PASSWORD``` of your [ODK Central App](https://docs.getodk.org/getting-started/) in your ```.env``` file.
```
ODK_API_URL="https://your_host.com/v1"
ODK_USER_EMAIL=your_email
ODK_USER_PASSWORD=your_password
```

Don't forget to run ```php artisan config:clear```

If you change your crendentials later you will also have to run ```php artisan cache:clear```.
The authentification token is cached for 3600 seconds.

## Usage

```php
namespace App\Http\Controllers;

use Mchev\LaravelOdk\OdkCentral;

class SomeController extends Controller
{
    public function testOdk()
    {
      $odk = new OdkCentral;

      $project = $odk->projects(1)->get();

      $form = $odk->projects(1)->forms('basic')->get();

      dd($project, $form);

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
$user = $odk->users()->create([
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
$appUser = $odk->projects($projectId)->appUsers()->create([
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
// List all forms of a project.
$forms = $odk->projects($projectId)->forms()->get();

// Creating new form (sending XForms XML or XLSForm file)
// If the second parameter is set to false, the form will be stored as draft.
$form = $odk->projects($projectId)->forms()->create($request->file('your_input_file'), true);

// Getting form details
$form = $odk->projects($projectId)->forms($xmlFormId)->get();

// Getting form fields
$form = $odk->projects($projectId)->forms($xmlFormId)->fields();

// Listing form attachments
$form = $odk->projects($projectId)->forms($xmlFormId)->attachments()->get();

// Downloading a form attachment
return $odk->projects($projectId)->forms($xmlFormId)->downloadAttachment($filename);

// Getting form shema fields
$form = $odk->projects($projectId)->forms($xmlFormId)->fields()->get();

// Modifying a form
$form = $odk->projects($projectId)->forms($xmlFormId)->update([
  'state' => 'open'
]);

// Deleting a form
$form = $odk->projects($projectId)->forms($xmlFormId)->delete();

// Download form file (xml, xls, xlsx)
return $odk->projects($projectId)->forms($xmlFormId)->xlsx()->download(); // xml(), xls(), xlsx()
```

### [Draft](https://odkcentral.docs.apiary.io/#reference/forms/draft-form)

```php
// Let's say we already have our form
$form = $odk->projects($projectId)->forms($xmlFormId);

// Create a new draft
$form->draft()->create($request->file('your_input_file'));

// Getting Draft Form Details
$form->draft()->get();

// Getting Draft Form Fields
$form->draft()->fields();

// Publish the draft
$form->draft()->publish('v1.2.0'); // string | optional

// Deleting the draft
$form->draft()->delete();

```

### [Submissions](https://odkcentral.docs.apiary.io/#reference/submissions)

```php
// Listing all submissions on a form
$submissions = $odk->projects($projectId)->forms($xmlFormId)->submissions()->get();

// Getting Submission metadata
$submissions = $odk->projects($projectId)->forms($xmlFormId)->submissions($instanceId)->get();

// Updating Submission metadata
$submissions = $odk->projects($projectId)->forms($xmlFormId)->submissions($instanceId)->update([
  'reviewState' => 'approved' // null, edited, hasIssues, rejected, approved | enum
]);

// Retrieving Submission XML
$submissions = $odk->projects($projectId)->forms($xmlFormId)->submissions($instanceId)->xml();

// Geting Submission comments
$submissions = $odk->projects($projectId)->forms($xmlFormId)->submissions($instanceId)->comments()->get();

// Posting Submission comments
$submission = $odk->projects($projectId)->forms($xmlFormId)->submissions($instanceId)->comments()->create([
  'body' => 'this is the text of my comment',
]);

```

### Answers/Responses
```php
// Our form
$form = $odk->projects($projectId)->forms($xmlFormId);

// You can get answers directly :
$answers = $form()->answers();
// OR
$anwserWithRepeats = $form()->answersWithRepeats();

// If you need to get only answers associated to a submission :
$answers = $form()->submissions($submissionId)->answers();
// OR
$anwserWithRepeats = $form()->submissions($submissionId)->answersWithRepeats();

// answersWithRepeats() method accept a boolean parameter to only get the questions and responses (no meta, ids, etc)
$onlyAnswers = $form()->submissions($submissionId)->answersWithRepeats(true);
```

### Odata
```php
// Our form
$form = $odk->projects($projectId)->forms($xmlFormId);

/**
 * OData request.
 *
 * @param string $url
 * @param boolean $top
 * @param boolean $skip
 * @param boolean $count
 * @param boolean $wkt
 * @param string $filter
 * @param boolean $expand
 */
$data = $form->odata($url= '', $top = false, $skip = false, $count = false, $wkt = false, $filter = '', $expand = false)->get();

// Example : 
$submissions = $form->odata('Submissions')->get();
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

-   [Martin Chevignard](https://github.com/mchev)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
