# Contao Lazy Bundle

> [!NOTE]
> **Contao** is an Open Source PHP Content Management System for people who want a professional website that is easy to
> maintain. Visit the [project website](https://contao.org) for more information.

You can be more lazy than ever when you follow the Contao best practices that are provided with this bundle.
## Install

```bash
composer require tastaturberuf/contao-lazy-bundle
```

## Features

Here are some of the features that this bundle provides:

### Lazy bundle setup

The bundle provides a `LazyBundle` class that you can use to create your own bundle.
You dont need to create a `Plugin` class anymore. At this time you have to manuel set the plugin class in your
`composer.json`.

```php
# /src/YourBundleName.php

namespace Vendor\YourBundleName;

use Tastaturberuf\ContaoLazyDevBundle\LazyBundle;

class YourBundleNameBundle extends LazyBundle {
}
```

This must be the namespace of your bundle class in your `composer.json`:.

```json
{
    "extra": {
        "contao-manager-plugin": "Vendor\\YourBundleName\\YourBundleNameBundle"
    }
}
```

I plan to skip this step in the future too.

### Auto configuration

All config files in `/config/*.{php,yaml}` will be automatically loaded. Except `/config/routes.{php,yaml}` will be
registered as routes. Also all files in `/config/routes/*.{php,xml}` will be registered as routes.

### Register Contao models

This method ensures that the provided model class exists, is a subclass of the base `Model` class, and optionally forces
registration even if it is already registered.
The model will be assigned to the global `$GLOBALS['TL_MODELS']` array using its table name as the key.

```php
# /contao/config/config.php

use Tastaturberuf\ContaoLazyDevBundle\Contao\ContaoConfig;

ContaoConfig::registerModel(YourModel::class);

ContaoConfig::registerModels(YourModel::class, YourOtherModel::class);
```

### Lazy ScopeMatcher

Instead of injecting two services for scope matching, you can use the `LazyScopeMatcher` class as wrapper.
As default the taken request is the current one. Since Contao 5.4 you dont need this anymore, you csn use
the default ScopeMatcher without needing the RequestStack.

```php
# /src/Services/YourService.php

use Tastaturberuf\ContaoLazyDevBundle\Contao\LazyScopeMatcher;

class YourService {
   public function __construct(LazyScopeMatcher $scopeMatcher) {
        $scopeMatcher->isFrontendRequest();
        $scopeMatcher->isBackendRequest();
        $scopeMatcher->isContaoRequest();
    }
}
```

### Lazy Alias Generator

You hate generating an alias? Me too. Just use the `LazyAliasGenerator` class to generate the alias in an oneliner.

```php
# /src/DataContainer/YourDataContainer.php

use Tastaturberuf\ContaoLazyBundle\Contao\LazyAliasGenerator;

public function generateAlias(string $alias, DC_Table $dc): string
{
    return $this->lazyAliasGenerator($dc->getActiveRecord()['name'], $alias, $dc, 'alias', 'custom-prefix-');
}

```

That's all. The Service checks for null values, trim strings, check for duplicates and numerical alias. It's awesome
easy to use.

## Maintainer

[![Daniel Rick](https://avatars.githubusercontent.com/u/1027521?s=128)](https://github.com/tastaturberuf)

[![Tastaturberuf](https://tastaturberuf.de/files/img/logo/2017.png)](https://tastaturberuf.de)

**PHP with ♥ and Contao**
