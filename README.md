# Konekt Client Library (Laravel)

[![Latest Stable Version](https://poser.pugx.org/konekt/client/version.svg)](https://packagist.org/packages/konekt/client)
[![Total Downloads](https://poser.pugx.org/konekt/client/downloads.svg)](https://packagist.org/packages/konekt/client)
[![Open Source Love](https://badges.frapsoft.com/os/mit/mit.svg?v=102)](https://github.com/ellerbrock/open-source-badge/)

This is a [Concord](https://github.com/artkonekt/concord) module.

If you don't know what this is, it's just too early.

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
