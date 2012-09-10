# RithisBootstrapBundle

Symfony2 Bundle with Twitter Bootstrap front-end framework and adopted templates.

## Installation

Run this command in your project directory:

``` bash
$ composer.phar require rithis/bootstrap-bundle:@dev
```

After that enable bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Rithis\BootstrapBundle\RithisBootstrapBundle(),
    );
}
```

## Usage

### Bootstrap Files

If you want just include Bootstrap files in your project
then run `php app/console assets:install` and include Bootstrap:

``` html
<link rel="stylesheet" href="/bundles/rithisbootstrap/css/bootstrap.min.css">
```

### Base Template

You can extend our base template `RithisBoootstrapBundle::base.html.twig`
with Bootstrap included for fast start

### Form Theme

We adopt Symfony2 form theme for Bootstrap. You can enable theme globally:

``` yaml
twig:
    form:
        resources:
            - form_div_layout.html.twig
            - RithisBootstrapBundle::form.html.twig
```

Or you can add theme to specific form:

```
{% form_theme form with ["RithisBootstrapBundle::form.html.twig"] %}
```
