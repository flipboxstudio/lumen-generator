<?php

namespace Flipbox\LumenGenerator;

use Illuminate\Support\Composer;
use Illuminate\Support\ServiceProvider;

class LumenGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'KeyGenerate' => 'command.key.generate',
        'Tinker' => 'command.tinker',
        'RouteList' => 'command.route.list',
        'ClearCompiled' => 'command.clear.compiled',
        'Optimize' => 'command.optimize',
        'FactoryMake' => 'command.factory.make',
    ];

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $devCommands = [
        'ConsoleMake' => 'command.console.make',
        'ControllerMake' => 'command.controller.make',
        'EventMake' => 'command.event.make',
        'ExceptionMake' => 'command.exception.make',
        'RequestMake' => 'command.request.make',
        'JobMake' => 'command.job.make',
        'ListenerMake' => 'command.listener.make',
        'MailMake' => 'command.mail.make',
        'MiddlewareMake' => 'command.middleware.make',
        'PipeMake' => 'command.pipe.make',
        'ModelMake' => 'command.model.make',
        'PolicyMake' => 'command.policy.make',
        'ProviderMake' => 'command.provider.make',
        'Serve' => 'command.serve',
        'TestMake' => 'command.test.make',
        'ResourceMake' => 'command.resource.make',
        'NotificationMake' => 'command.notification.make',
        'NotificationTable' => 'command.notification.table',
        'ChannelMake' => 'command.channel.make',
        'SchemaDump' => 'command.schema.dump',
        'CastMake' => 'command.cast.make',
        'RuleMake' => 'command.rule.make',
        'ObserverMake' => 'command.observer.make',
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerCommands($this->commands);
        $this->registerCommands($this->devCommands);
    }

    /**
     * Register the given commands.
     *
     * @param array $commands
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $method = "register{$command}Command";

            call_user_func_array([$this, $method], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     */
    protected function registerRouteListCommand()
    {
        $this->app->singleton('command.route.list', function ($app) {
            return new Console\RouteListCommand();
        });
    }

    /**
     * Register the command.
     */
    protected function registerTinkerCommand()
    {
        $this->app->singleton('command.tinker', function ($app) {
            return new Console\TinkerCommand();
        });
    }

    /**
     * Register the command.
     */
    protected function registerClearCompiledCommand()
    {
        $this->app->singleton('command.clear.compiled', function ($app) {
            return new Console\ClearCompiledCommand();
        });
    }

    /**
     * Register the command.
     */
    protected function registerOptimizeCommand()
    {
        $this->app->singleton('command.optimize', function ($app) {
            $app->configure('compile');

            $app['config']->set('optimizer', require_once(__DIR__.'/config/optimizer.php'));

            return new Console\OptimizeCommand(new Composer($app['files']));
        });
    }

    /**
     * Register the command.
     */
    protected function registerConsoleMakeCommand()
    {
        $this->app->singleton('command.console.make', function ($app) {
            return new Console\ConsoleMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerControllerMakeCommand()
    {
        $this->app->singleton('command.controller.make', function ($app) {
            return new Console\ControllerMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerEventMakeCommand()
    {
        $this->app->singleton('command.event.make', function ($app) {
            return new Console\EventMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerExceptionMakeCommand()
    {
        $this->app->singleton('command.exception.make', function ($app) {
            return new Console\ExceptionMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerFactoryMakeCommand()
    {
        $this->app->singleton('command.factory.make', function ($app) {
            return new Console\FactoryMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerJobMakeCommand()
    {
        $this->app->singleton('command.job.make', function ($app) {
            return new Console\JobMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerKeyGenerateCommand()
    {
        $this->app->singleton('command.key.generate', function () {
            return new Console\KeyGenerateCommand();
        });
    }

    /**
     * Register the command.
     */
    protected function registerListenerMakeCommand()
    {
        $this->app->singleton('command.listener.make', function ($app) {
            return new Console\ListenerMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerMailMakeCommand()
    {
        $this->app->singleton('command.mail.make', function ($app) {
            return new Console\MailMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerMiddlewareMakeCommand()
    {
        $this->app->singleton('command.middleware.make', function ($app) {
            return new Console\MiddlewareMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerRequestMakeCommand()
    {
        $this->app->singleton('command.request.make', function ($app) {
            return new Console\RequestMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerPipeMakeCommand()
    {
        $this->app->singleton('command.pipe.make', function ($app) {
            return new Console\PipeMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerModelMakeCommand()
    {
        $this->app->singleton('command.model.make', function ($app) {
            return new Console\ModelMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerProviderMakeCommand()
    {
        $this->app->singleton('command.provider.make', function ($app) {
            return new Console\ProviderMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerSeederMakeCommand()
    {
        $this->app->singleton('command.seeder.make', function ($app) {
            return new Console\SeederMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerServeCommand()
    {
        $this->app->singleton('command.serve', function () {
            return new Console\ServeCommand();
        });
    }

    /**
     * Register the command.
     */
    protected function registerTestMakeCommand()
    {
        $this->app->singleton('command.test.make', function ($app) {
            return new Console\TestMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerResourceMakeCommand()
    {
        $this->app->singleton('command.resource.make', function ($app) {
            return new Console\ResourceMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerPolicyMakeCommand()
    {
        $this->app->singleton('command.policy.make', function ($app) {
            return new Console\PolicyMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerNotificationTableCommand()
    {
        $this->app->singleton('command.notification.table', function ($app) {
            return new Console\NotificationTableCommand($app['files'], $app['composer']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerNotificationMakeCommand()
    {
        $this->app->singleton('command.notification.make', function ($app) {
            return new Console\NotificationMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerChannelMakeCommand()
    {
        $this->app->singleton('command.channel.make', function ($app) {
            return new Console\ChannelMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     */
    protected function registerSchemaDumpCommand()
    {
        $this->app->singleton('command.schema.dump', function () {
            return new Console\DumpCommand();
        });
    }

    protected function registerCastMakeCommand()
    {
        $this->app->singleton('command.cast.make', function ($app) {
            return new Console\CastMakeCommand($app['files']);
        });
    }

    protected function registerRuleMakeCommand()
    {
        $this->app->singleton('command.rule.make', function ($app) {
            return new Console\RuleMakeCommand($app['files']);
        });
    }

    protected function registerObserverMakeCommand()
    {
        $this->app->singleton('command.observer.make', function ($app) {
            return new Console\ObserverMakeCommand($app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        if ($this->app->environment('production')) {
            return array_values($this->commands);
        } else {
            return array_merge(array_values($this->commands), array_values($this->devCommands));
        }
    }
}
