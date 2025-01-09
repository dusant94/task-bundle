

**Installation**

```bash
composer require solvex/test-bundle
```

Enable it:
```bash
// config/bundles.php
return [
    // ...
    SolveX\TaskBundle\SolveXTaskBundle::class => ['all' => true],
];
```

Install:
```bash
php bin/console pimcore:bundle:install SolveXTaskBundle
``` 

**Uninstall**

```bash
php bin/console pimcore:bundle:uninstall SolveXTaskBundle
``` 

```bash
composer remove solvex/test-bundle
```

