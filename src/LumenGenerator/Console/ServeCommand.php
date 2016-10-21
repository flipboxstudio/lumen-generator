<?php

namespace Flipbox\LumenGenerator\Console;

use Illuminate\Console\Command;
use Symfony\Component\Process\ProcessUtils;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\PhpExecutableFinder;

class ServeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the application on the PHP development server';

    /**
     * Execute the console command.
     *
     *
     * @throws \Exception
     */
    public function fire()
    {
        chdir($this->laravel->basePath('public'));

        $host = $this->input->getOption('host');

        $port = $this->input->getOption('port');

        $base = ProcessUtils::escapeArgument($this->laravel->basePath());

        $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder())->find(false));

        $this->info("Laravel development server started on http://{$host}:{$port}/");

        if (file_exists("{$base}/server.php")) {
            passthru("{$binary} -S {$host}:{$port} {$base}/server.php");
        } else {
            passthru("{$binary} -S {$host}:{$port} -t {$base}/public/");
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['host', null, InputOption::VALUE_OPTIONAL, 'The host address to serve the application on.', 'localhost'],

            ['port', null, InputOption::VALUE_OPTIONAL, 'The port to serve the application on.', 8000],
        ];
    }
}
