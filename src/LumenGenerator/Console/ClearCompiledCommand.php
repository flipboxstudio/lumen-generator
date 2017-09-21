<?php

namespace Flipbox\LumenGenerator\Console;

use Illuminate\Console\Command;

class ClearCompiledCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'clear-compiled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the compiled class file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $compiledPath = base_path('bootstrap/cache/compiled.php');

        if (file_exists($compiledPath)) {
            @unlink($compiledPath);
        }
    }
}
