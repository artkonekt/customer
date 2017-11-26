# Konekt Customer Library (Laravel)

[![Travis Build Status](https://img.shields.io/travis/artkonekt/customer.svg?style=flat-square)](https://travis-ci.org/artkonekt/customer)
[![Packagist version](https://img.shields.io/packagist/v/konekt/customer.svg?style=flat-square)](https://packagist.org/packages/konekt/customer)
[![Packagist downloads](https://img.shields.io/packagist/dt/konekt/customer.svg?style=flat-square)](https://packagist.org/packages/konekt/customer)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

This is a [Concord](https://github.com/artkonekt/concord) module for
handling customers. Designed to be basic and with later extension in
mind.

## Runnig Tests

### In Console

```bash
vendor/bin/phpunit -c phpunit.xml
```

### Configure PhpStorm

1. Go to settings -> PHP -> Testing frameworks
2. Add PHPUnit local
3. Choose composer autoloader (need to install deps in advance with `composer install`)
4. Point "path to script" to `vendor/autoload.php` (full path)
5. Choose default configuration file: `phpunit.xml`
