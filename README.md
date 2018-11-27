Composer Package Boilerplate
============================

This project is meant to reduce common and repetitive steps during a Composer package creation.


Development
-----------

The `run` bash script is a wrapper of a php docker container. It will bootstrap the container and run a given command inside of it. The container should have all needed tools for development. Please, let know the project maintainer if something is missing.

To add new packages in the `composer.json` file, use [`composer require`](https://getcomposer.org/doc/03-cli.md#require)

```bash
./run composer require [--dev] [vendor/package:version]
```

To install packages defined in the `composer.json` file, use [`composer install`](https://getcomposer.org/doc/03-cli.md#install-i)

```bash
./run composer install
```
