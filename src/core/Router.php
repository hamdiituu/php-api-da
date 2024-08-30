<?php

namespace Core;

class Router
{
    private $routes = [];
    private $prefix = '';

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    public function add($method, $uri, $callback)
    {
        // URI'yi son eğik çizgi ile standartlaştırma
        $uri = rtrim($this->prefix . $uri, '/');
        $this->routes[$method][$uri] = $callback;
    }

    public function get($uri, $callback)
    {
        $this->add('GET', $uri, $callback);
    }

    public function post($uri, $callback)
    {
        $this->add('POST', $uri, $callback);
    }

    public function put($uri, $callback)
    {
        $this->add('PUT', $uri, $callback);
    }

    public function delete($uri, $callback)
    {
        $this->add('DELETE', $uri, $callback);
    }

    public function group($prefix, $callback)
    {
        $previousPrefix = $this->prefix;
        $this->prefix .= rtrim($prefix, '/'); // Prefix'ı son eğik çizgisiz ayarla

        $callback($this);

        $this->prefix = $previousPrefix;
    }

    public function dispatch($method, $uri)
    {
        $uri = rtrim(strtok($uri, '?'), '/'); // Remove query string and trailing slash

        foreach ($this->routes[$method] as $routeUri => $callback) {
            $pattern = preg_replace('/{[^}]+}/', '([^/]+)', $routeUri);
            $pattern = str_replace('/', '\/', $pattern);
            if (preg_match('/^' . $pattern . '$/', $uri, $matches)) {
                array_shift($matches); // Remove the full match
                call_user_func_array($callback, $matches);
                return;
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['message' => '404 Not Found']);
    }
}
