Collection
==========

PHP library to create custom collections.


Usage
-----

Define a custom collection, extending library's abstract collection and defining the item and offset types

```php
<?php

class MyCustomCollection extends \Tandiljuan\Collection\AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected $itemType = '\DateTime';

    /**
     * {@inheritdoc}
     */
    protected $offsetType = 'integer';
}
```

Create a collection that only will allow the item and offset types you have defined

```php
<?php

$collection = new MyCustomCollection();

try {
    $collection[] = 'error';
} catch (\Tandiljuan\Collection\Exception\InvalidItemType $e) {
    echo "Invalid item type\n";
}

try {
    $collection['a'] = new \DateTime();
} catch (\Tandiljuan\Collection\Exception\InvalidOffsetType $e) {
    echo "Invalid offset type\n";
}

$collection[] = new DateTime('2001-01-01 01:01:01');
$collection[] = new DateTime('2002-02-02 02:02:02');
$collection[] = new DateTime('2003-03-03 03:03:03');
```

Require parameters to be of _MyCustomCollection_ using [type declarations](http://php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration)

```php
<?php

function printItems(MyCustomCollection $parameter)
{
    foreach ($parameter as $item) {
        echo $item->format('r')."\n";
    }
}

printItems($collection);

// The output will be
// Mon, 01 Jan 2001 01:01:01 +0000
// Sat, 02 Feb 2002 02:02:02 +0000
// Mon, 03 Mar 2003 03:03:03 +0000
```


Development
-----------

Contributions must follow [Symfony Coding Standards](https://symfony.com/doc/current/contributing/code/standards.html).

It's encouraged to read the following documentation:

* [PHP The Right Way](https://phptherightway.com/)
* [Git Best Practices](http://sethrobertson.github.io/GitBestPractices/)

The `run` bash script is a wrapper of a php docker container. It will bootstrap the container and run a given command inside of it. The container should have all needed tools for development. Please, let know the project maintainer if something is missing.

To add new packages in the `composer.json` file, use [`composer require`](https://getcomposer.org/doc/03-cli.md#require)

```bash
./run composer require [--dev] [vendor/package:version]
```

To install packages defined in the `composer.json` file, use [`composer install`](https://getcomposer.org/doc/03-cli.md#install-i)

```bash
./run composer install
```

To check PHP code against coding standards, use [`php-cs-fixer`](https://github.com/FriendsOfPHP/PHP-CS-Fixer)

```bash
# Check if a file needs to be fixed
./run php-cs-fixer fix --dry-run --diff path/to/file.php
# Fix a file
./run php-cs-fixer fix path/to/file.php
```

To run PHP REPL interactive shell, use [`php`](http://php.net/manual/en/features.commandline.interactive.php) or [`psysh`](https://psysh.org/)

```bash
# Using PHP
./run php -a
# Using psysh
./run psysh
```


Testing
-------

Bootstrap [Codeception](https://codeception.com/) test environment. This must be done only once.

```bash
$ # Bootstrap codeception without the standard suites
$ ./run codecept bootstrap --empty --namespace 'Tandiljuan\Collection\Tests'
```

Create a codeception test suit. This must be done only once per suit.

```bash
$ # Create `unit` suit (for unit testing)
$ ./run codecept generate:suite unit
```

Create a [Cest](https://codeception.com/docs/02-GettingStarted#Writing-a-Sample-Test) class under a given suit. Can create as many _Cest_ classes as needed.

```bash
$ # Create a new cest `Dummy` under the `unit` suit
$ ./run codecept generate:cest unit Dummy
```

After writing the tests, can execute them using the `run` command

```bash
$ ./run codecept run
```
