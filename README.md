# Contao Lazy Dev

> [!NOTE]
> **Contao** is an Open Source PHP Content Management System for people who want a professional website that is easy to
> maintain. Visit the [project website][1] for more information.

You can be more lazy than ever when you follow the Contao best practices that are provided with this bundle.
## Install

```bash
composer require tastaturberuf/contao-lazy-dev-bundle
```

## Features

Here are some of the features that this bundle provides:

### Lazy bundle setup

The bundle provides a `AbstractContaoBundle` class that you can use to create your own bundle.
You dont need to create a `Plugin` class anymore. At this time you have to manuel set the plugin class in your
`composer.json`.

```php
# /src/YourBundleName.php

namespace Vendor\YourBundleName;

use Tastaturberuf\ContaoLazyDevBundle\AbstractContaoBundle;

class YourBundleNameBundle extends AbstractContaoBundle {
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

- If you have a `/config/service.php` in your bundle, the bundle will automatically register your services.
- If you have a `/config/routes.php` in your bundle, the bundle will automatically register your routes.

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

## Maintainer

[![Daniel Rick](https://avatars.githubusercontent.com/u/1027521?s=128)][3]

[![Tastaturberuf](https://tastaturberuf.de/files/img/logo/2017.png)][2]

**PHP with ♥ and Contao**

[1]: https://contao.org
[2]: https://tastaturberuf.de

[3]: https://github.com/tastaturberuf
