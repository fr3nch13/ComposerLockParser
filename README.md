Composer.lock Parser
==================

OOP reader of composer.lock file

This is a for o the original project located at: https://github.com/t4web/ComposerLockParser

Introduction
------------
Parse composer.lock file and return full information about installed packages in OOP style.

Requirements
------------
PHP >= 7.4

TODO
------------
- Add more info to the Package.php with info from the composer.lock

Installation
------------
### Main Setup

composer.json:
```json
"require": {
    "fr3nch13/composer-lock-parser": "~1.0"
}
```
OR
```bash
composer require fr3nch13/composer-lock-parser
```

Usage
------------
Creating ComposerInfo object and getting all of the packages
```php
$composerInfo = new \ComposerLockParser\ComposerInfo('/path/to/composer.lock');
// default all packages
$packages = $composerInfo->getPackages();
// or explicitly get all packages
$packages = $composerInfo->getPackages($composerInfo::ALL);

echo $packages[0]->getName();
echo $packages[0]->getVersion();
echo $packages[0]->getNamespace();
```

Getting just production packages.
```php
$composerInfo = new \ComposerLockParser\ComposerInfo('/path/to/composer.lock');
$packages = $composerInfo->getPackages($composerInfo::PRODUCTION);
```

Getting just development packages.
```php
$composerInfo = new \ComposerLockParser\ComposerInfo('/path/to/composer.lock');
$packages = $composerInfo->getPackages($composerInfo::DEVELOPMENT);
```

Testing
------------
Tests runs with Phpunit, phpstan, and phpcs
I reccommend running `composer ci` before committing your code and pushing it to github.
See the `scripts` in `composer.json`.
```bash
$ composer ci
$ composer test
$ composer cs-check
$ composer phpstan
```
