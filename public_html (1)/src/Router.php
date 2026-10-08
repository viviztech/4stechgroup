<?php

declare(strict_types=1);

/**
 * Minimal path-based router. No framework: routes are matched in
 * definition order against a regex built from a simple `{param}`
 * placeholder syntax, and the winning route just includes a plain
 * PHP page file from /pages with $params extracted into scope.
 */
final class Router
{
    /** @var array<int, array{methods: array<int, string>, pattern: string, regex: string, page: string}> */
    private array $routes = [];

    /** @var array<string, string> exact-path 301 redirects (old URL => new URL) */
    private array $redirects = [];

    /** @var array<int, array{prefix: string, replacement: string}> prefix 301 redirects */
    private array $prefixRedirects = [];

    public function get(string $pattern, string $page): void
    {
        $this->map(['GET', 'HEAD'], $pattern, $page);
    }

    public function any(string $pattern, string $page): void
    {
        $this->map(['GET', 'HEAD', 'POST'], $pattern, $page);
    }

    /** @param array<int, string> $methods */
    private function map(array $methods, string $pattern, string $page): void
    {
        $regex = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $pattern);
        preg_match_all('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', $pattern, $names);

        $this->routes[] = [
            'methods' => $methods,
            'pattern' => $pattern,
            'regex' => '#^' . $regex . '$#',
            'names' => $names[1],
            'page' => $page,
        ];
    }

    public function redirect(string $from, string $to): void
    {
        $this->redirects[rtrim($from, '/')] = $to;
    }

    public function redirectPrefix(string $fromPrefix, string $toPrefix): void
    {
        $this->prefixRedirects[] = ['prefix' => rtrim($fromPrefix, '/'), 'replacement' => rtrim($toPrefix, '/')];
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $path = rawurldecode($path);
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        if (isset($this->redirects[$path])) {
            $this->sendRedirect($this->redirects[$path]);
            return;
        }

        foreach ($this->prefixRedirects as $redirect) {
            if ($path === $redirect['prefix'] || str_starts_with($path, $redirect['prefix'] . '/')) {
                $rest = substr($path, strlen($redirect['prefix']));
                $this->sendRedirect($redirect['replacement'] . $rest);
                return;
            }
        }

        foreach ($this->routes as $route) {
            if (!in_array($method, $route['methods'], true)) {
                continue;
            }
            if (preg_match($route['regex'], $path, $matches) === 1) {
                array_shift($matches);
                $params = array_combine($route['names'], $matches);
                $this->renderPage($route['page'], $params);
                return;
            }
        }

        http_response_code(404);
        $this->renderPage('not-found', []);
    }

    private function sendRedirect(string $to): void
    {
        http_response_code(301);
        header('Location: ' . url($to));
    }

    /** @param array<string, string> $params */
    private function renderPage(string $page, array $params): void
    {
        $file = dirname(__DIR__) . '/pages/' . $page . '.php';
        if (!is_file($file)) {
            http_response_code(500);
            echo 'Page not found: ' . e($page);
            return;
        }
        require $file;
    }
}
