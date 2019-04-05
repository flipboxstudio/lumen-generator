<?php

namespace Flipbox\LumenGenerator\Console;

use Dingo\Api\Routing\Router;
use Illuminate\Console\Command;

class RouteListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'route:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all registered routes.';

    /**
     * Get the router.
     *
     * @return \Laravel\Lumen\Routing\Router
     */
    protected function getRouter()
    {
        if(isset($this->laravel->router)) {
            return $this->laravel->router;
        }

        return $this->laravel;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $router = $this->getRouter();
        $routeCollection = $router->getRoutes();
        $rows = array();

        foreach ($routeCollection as $route) {
            $rows[] = [
                'verb' => $route['method'],
                'path' => $route['uri'],
                'namedRoute' => $this->getNamedRoute($route['action']),
                'controller' => $this->getController($route['action']),
                'action' => $this->getAction($route['action']),
                'middleware' => $this->getMiddleware($route['action']),
            ];
        }

        if ($this->laravel->bound(Router::class)) {
            $routes = $this->laravel->make(Router::class)->getRoutes();

            foreach ($routes as $route) {
                foreach ($route->getRoutes() as $innerRoute) {
                    $rows[] = [
                        'verb' => implode($innerRoute->getMethods(), '|'),
                        'path' => $innerRoute->getPath(),
                        'namedRoute' => $innerRoute->getName(),
                        'controller' => get_class($innerRoute->getControllerInstance()),
                        'action' => $this->getAction($innerRoute->getAction()),
                        'middleware' => implode($innerRoute->getMiddleware(), '|'),
                    ];
                }
            }
        }

        $headers = array('Verb', 'Path', 'NamedRoute', 'Controller', 'Action', 'Middleware');
        $this->table($headers, $rows);
    }

    /**
     * @param array $action
     * @return string
     */
    protected function getNamedRoute(array $action)
    {
        if(!isset($action['as'])) {
            return '';
        }

        return $action['as'];
    }

    /**
     * @param array $action
     * @return mixed|string
     */
    protected function getController(array $action)
    {
        if (empty($action['uses'])) {
            return 'None';
        }

        return current(explode('@', $action['uses']));
    }

    /**
     * @param array $action
     * @return string
     */
    protected function getAction(array $action)
    {
        if (empty($action['uses'])) {
            return 'Closure';
        }

        $data = $action['uses'];

        if(($pos = strpos($data, '@')) !== false) {
            return substr($data, $pos + 1);
        }

        return 'METHOD NOT FOUND';
    }

    /**
     * @param array $action
     * @return string
     */
    protected function getMiddleware(array $action)
    {
        if(!isset($action['middleware'])) {
            return '';
        }

        if(is_array($action['middleware'])) {
            return implode(', ', $action['middleware']);
        }

        return $action['middleware'];
    }
}
