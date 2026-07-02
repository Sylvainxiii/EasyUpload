<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => [],
    ];

    public function get(string $uri, callable|array $action): void
    {
        $this->add('GET', $uri, $action);
    }

    public function post(string $uri, callable|array $action): void
    {
        $this->add('POST', $uri, $action);
    }

    public function put(string $uri, callable|array $action): void
    {
        $this->add('PUT', $uri, $action);
    }

    public function patch(string $uri, callable|array $action): void
    {
        $this->add('PATCH', $uri, $action);
    }

    public function delete(string $uri, callable|array $action): void
    {
        $this->add('DELETE', $uri, $action);
    }

    private function add(string $method, string $uri, callable|array $action): void
    {
        $this->routes[$method][$this->normalize($uri)] = $action;
    }

    // public function dispatch(Request $request): mixed
    // {
    //     $method = strtoupper($request->method());
    //     $uri = $this->normalize($request->uri());
    //
    //     $action = $this->routes[$method][$uri] ?? null;
    //
    //     if (!$action) {
    //         return $this->handleNotFound($request);
    //     }
    //
    //     if (is_callable($action)) {
    //         return $action($request);
    //     }
    //
    //     if (is_array($action) && count($action) === 2) {
    //         [$class, $handler] = $action;
    //
    //         $controller = new $class();
    //
    //         return $controller->$handler($request);
    //     }
    //
    //     throw new \RuntimeException('Invalid route action.');
    // }

    public function dispatch(Request $request): mixed
    {
        $method = strtoupper($request->method());
        $uri = $this->normalize($request->uri());

        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            return $this->handleNotFound($request);
        }

        if (is_callable($action)) {
            return $action($request);
        }

        if (is_array($action) && count($action) === 2) {
            [$class, $handler] = $action;

            // Injection des dépendances via constructeur
            $controller = $this->resolveController($class);

            return $controller->$handler($request);
        }

        throw new \RuntimeException('Invalid route action.');
    }

    private function handleNotFound(Request $request): void
    {
        Response::status(404);

        \App\Core\View::render('errors/404', [
            'title' => 'Page introuvable',
            'uri'   => $request->uri(),
        ]);

        exit;
    }

    private function normalize(string $uri): string
    {
        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        return $uri ?: '/';
    }

    private function resolveController(string $class): object
    {
        // Vérifier si la classe a un constructeur
        if (!method_exists($class, '__construct')) {
            return new $class();
        }

        // Utiliser la réflexion pour analyser le constructeur
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $parameters = $constructor->getParameters();

        if (empty($parameters)) {
            return new $class();
        }

        // Résoudre chaque paramètre
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $paramType = $parameter->getType();

            if (!$paramType || $paramType->isBuiltin()) {
                // Type scalaire - on passe null ou valeur par défaut
                $dependencies[] = $parameter->isDefaultValueAvailable()
                    ? $parameter->getDefaultValue()
                    : null;
                continue;
            }

            $typeName = $paramType->getName();

            // Instancier automatiquement le service (si pas de dépendances elle-même)
            if (class_exists($typeName)) {
                $dependencies[] = $this->resolveController($typeName);
            } else {
                $dependencies[] = null;
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}
