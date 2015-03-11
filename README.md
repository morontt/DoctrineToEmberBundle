# DoctrineToEmberBundle

Convert Doctrine2 models to Ember-Data models

Installation
------------

Just add the package to your `composer.json`

```json
{
    "require": {
        "morontt/doctrine-to-ember": "dev-master"
    }
}
```

or running the command:

```bash
php composer.phar require morontt/doctrine-to-ember "dev-master"
```

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Mtt\Bundle\DoctrineToEmberBundle\MttDoctrineToEmberBundle(),
    );
}
```

Configure the DoctrineToEmberBundle:

``` yaml
# app/config/config.yml

mtt_doctrine_to_ember:
    application_variable: MySuperApp
    models_path: "%kernel.root_dir%/../web/js/app/models"
```

Usage
-----

Running the command:

```bash
app/console mtt:generate:models
```
