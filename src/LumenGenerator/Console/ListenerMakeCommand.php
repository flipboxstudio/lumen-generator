<?php

namespace Flipbox\LumenGenerator\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ListenerMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:listener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event listener class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Listener';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('event')) {
            return $this->error('Missing required option: --event');
        }

        parent::handle();
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $event = $this->option('event');

        if (!Str::startsWith($event, $this->laravel->getNamespace()) && !Str::startsWith($event, 'Illuminate')) {
            $event = $this->laravel->getNamespace().'Events\\'.$event;
        }

        $stub = str_replace(
            'DummyEvent',
            class_basename($event),
            $stub
        );

        $stub = str_replace(
            'DummyFullEvent',
            $event,
            $stub
        );

        return $stub;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('queued')) {
            return __DIR__.'/stubs/listener-queued.stub';
        }

        return __DIR__.'/stubs/listener.stub';
    }

    /**
     * Determine if the class already exists.
     *
     * @param string $rawName
     *
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        return class_exists($rawName);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Listeners';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['event', null, InputOption::VALUE_REQUIRED, 'The event class being listened for.'],

            ['queued', null, InputOption::VALUE_NONE, 'Indicates the event listener should be queued.'],
        ];
    }
}
