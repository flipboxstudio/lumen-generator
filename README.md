# Lumen Generator

[![Total Downloads](https://poser.pugx.org/flipbox/lumen-generator/d/total.svg)](https://packagist.org/packages/flipbox/lumen-generator)
[![Latest Stable Version](https://poser.pugx.org/flipbox/lumen-generator/v/stable.svg)](https://packagist.org/packages/flipbox/lumen-generator)
[![Latest Unstable Version](https://poser.pugx.org/flipbox/lumen-generator/v/unstable.svg)](https://packagist.org/packages/flipbox/lumen-generator)
[![License](https://poser.pugx.org/flipbox/lumen-generator/license.svg)](https://packagist.org/packages/flipbox/lumen-generator)

Do you miss any Laravel code generator on your Lumen project?
If yes, then you're in the right place.

## Installation

To use _some_ generators command in Lumen (just like you do in Laravel), you need to add this package:

```sh
composer require flipbox/lumen-generator
```

## Configuration

Inside your `bootstrap/app.php` file, add:

```php
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
```

## Available Command

```
key:generate         Set the application key

make:cast            Create a new custom Eloquent cast class
make:channel         Create a new channel class
make:command         Create a new Artisan command
make:controller      Create a new controller class
make:event           Create a new event class
make:exception       Create a new custom exception class
make:factory         Create a new model factory
make:job             Create a new job class
make:listener        Create a new event listener class
make:mail            Create a new email class
make:middleware      Create a new middleware class
make:migration       Create a new migration file
make:model           Create a new Eloquent model class
make:notification    Create a new notification class
make:observer        Create a new observer class
make:pipe            Create a new pipe class
make:policy          Create a new policy class
make:provider        Create a new service provider class
make:request         Create a new form request class
make:resource        Create a new resource
make:rule            Create a new rule
make:seeder          Create a new seeder class
make:test            Create a new test class

notifications:table  Create a migration for the notifications table

schema:dump          Dump the given database schema
```

## Additional Useful Command

```
clear-compiled    Remove the compiled class file
serve             Serve the application on the PHP development server
tinker            Interact with your application
optimize          Optimize the framework for better performance
route:list        Display all registered routes.
```

> **NOTES** `route:list` command has been added via [appzcoder/lumen-route-list](https://github.com/appzcoder/lumen-route-list) package.

## Tinker `include` Argument Usage

`php artisan tinker path/to/tinker/script.php`

script.php example:
```
$environment = app()->environment();
$output = new Symfony\Component\Console\Output\ConsoleOutput();
$output->writeln("<info>Hello the app environment is `{$environment}`</info>");
$output->writeln("<comment>Did something</comment>");
$output->writeln("<error>Did something bad</error>");
```
