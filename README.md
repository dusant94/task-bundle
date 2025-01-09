

**Installation**

```bash
composer require solvex/test-bundle
```

Enable it:
```bash
// config/bundles.php
return [
    // ...
    SolveX\TaskBundle\DusantTaskBundle::class => ['all' => true],
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
composer remove solvex/test-bundle
```

