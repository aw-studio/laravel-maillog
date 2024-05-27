# Laravel Maillog
Automatically log information about all outgoing mail in your Laravel application

## Setup

You can install the package via composer:

```sh
composer require aw-studio/laravel-maillog
```

Your application will now log outgoing email information to a `maillog.log` file
in the `storage/logs` folder.

## Configuration

### Log to Database
Additionally, if you want to log your outgoing mails to your database,
you may do so with the following steps:

Publishing the package configuration and database migrations
```sh
php artisan vendor:publish --provider="AwStudio\Maillog\MaillogServiceProvider"
```

Run the migrations
```sh
php artisan migrate
```

Update the `channels` config in `config/maillog.php`:
```php
    'channels' => [
        // 'log',
        'database',
    ],
```

### Sending Event
By default, this package is configured so that it only logs when mails have been `sent`. You can change the configuration so that `sending` is also logged. This generates very similar data records, but can be useful to be able to trace whether problems have occurred on the way and the dispatch has failed unexpectedly.
```php
'logs' => [
    'sent',
    'sending',
],
```
