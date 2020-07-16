<?php

namespace Flipbox\LumenGenerator\Console;

class PipeMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:pipe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new pipe class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Pipe';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/pipe.stub';
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
        return $rootNamespace.'\Pipes';
    }
}
