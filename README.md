

**Installation**

```bash
composer require dusant94/task-bundle
```

Enable it:
```bash
// config/bundles.php
return [
    // ...
    Dusant\TaskBundle\DusantTaskBundle::class => ['all' => true],
];
```

Install:
```bash
php bin/console pimcore:bundle:install DusantTaskBundle
``` 

**Uninstall**

```bash
php bin/console pimcore:bundle:uninstall DusantTaskBundle
``` 

```bash
composer remove dusant94/task-bundle
```

**Updating or creating Product with command**
```bash
php bin/console dusant:create-or-update-product <sku> <name> 
``` 

**Updating or creating Product with api endpoint**
```bash

``` 