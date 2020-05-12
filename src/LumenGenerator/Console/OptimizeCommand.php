<?php

namespace Flipbox\LumenGenerator\Console;

use ClassPreloader\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use ClassPreloader\OutputWriter;
use ClassPreloader\CodeGenerator;
use Symfony\Component\Console\Input\InputOption;
use ClassPreloader\Exception\VisitorExceptionInterface as V4VisitorException;
use ClassPreloader\Exceptions\VisitorExceptionInterface as V3VisitorException;

class OptimizeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the framework for better performance';

    /**
     * The composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new optimize command instance.
     *
     * @param \Illuminate\Support\Composer $composer
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating optimized class loader');

        $this->laravel->configure('optimizer');

        $this->composer->dumpAutoloads('--no-dev --optimize');

        if ($this->option('force') || !env('APP_DEBUG')) {
            $this->info('Compiling common classes');

            if (class_exists(Factory::class)) {
                $this->compileClassesV3();
            } else {
                $this->compileClassesV4();
            }
        } else {
            $this->call('clear-compiled');
        }
    }

    /**
     * Generate the compiled class file.
     */
    protected function compileClassesV3()
    {
        $preloader = (new Factory())->create(['skip' => true]);

        $handle = $preloader->prepareOutput(base_path('bootstrap/cache/compiled.php'));

        try {
            foreach ($this->getClassFiles() as $file) {
                try {
                    fwrite($handle, $preloader->getCode($file, false)."\n");
                } catch (V3VisitorException $e) {
                    //
                }
            }
        } finally {
            fclose($handle);
        }
    }

    /**
     * Generate the compiled class file.
     */
    protected function compileClassesV4()
    {
        $codeGen = CodeGenerator::create(['skip' => true]);

        $handle = OutputWriter::openOutputFile(base_path('bootstrap/cache/compiled.php'));

        try {
            OutputWriter::writeOpeningTag($handle, false);

            foreach ($this->getClassFiles() as $file) {
                try {
                    $code = $codeGen->getCode($file, false);
                    OutputWriter::writeFileContent($handle, $code."\n");
                } catch (V4VisitorException $e) {
                    //
                }
            }
        } finally {
            OutputWriter::closeHandle($handle);
        }
    }

    /**
     * Get the classes that should be combined and compiled.
     *
     * @return array
     */
    protected function getClassFiles()
    {
        $app = $this->laravel;

        $core = $app['config']->get('optimizer.core');

        $files = array_merge($core, $app['config']->get('compile.files', []));

        foreach ($app['config']->get('compile.providers', []) as $provider) {
            $files = array_merge($files, forward_static_call([$provider, 'compiles']));
        }

        return array_filter(array_map('realpath', $files));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the compiled class file to be written.'],
        ];
    }
}
