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
key:generate      Set the application key

make:command      Create a new Artisan command
make:controller   Create a new controller class
make:event        Create a new event class
make:job          Create a new job class
make:listener     Create a new event listener class
make:mail         Create a new email class
make:middleware   Create a new middleware class
make:migration    Create a new migration file
make:model        Create a new Eloquent model class
make:policy       Create a new policy class
make:provider     Create a new service provider class
make:seeder       Create a new seeder class
make:test         Create a new test class
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
