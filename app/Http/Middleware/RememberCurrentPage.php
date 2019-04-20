<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;

class RememberCurrentPage
{
    public const PAGE_NAME = 'PAGE_NAME';

    /**
     * List of excluded route names
     *
     * @var string[]
     */
    protected $excludedPages = [
        'login',
        'registration'
    ];

    /**
     * @var \Illuminate\Support\Facades\Session
     */
    protected $session;

    /**
     * @var \Illuminate\Routing\Router
     */
    private $router;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    private $user;

    /**
     * RememberCurrentPage constructor.
     * @param \Illuminate\Routing\Router $router
     * @param \Illuminate\Contracts\Session\Session $session
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user
     */
    public function __construct(Router $router, Session $session, Authenticatable $user = null)
    {
        $this->router = $router;
        $this->session = $session;
        $this->user = $user;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->session->has(static::PAGE_NAME)) {
            $this->session->put(static::PAGE_NAME, '/');
        }

        $response = $next($request);

        if ($this->user === null) {
            $this->rememberRoute($request);
        }

        return $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function rememberRoute(Request $request): void
    {
        if (in_array($this->router->current()->getName(), $this->excludedPages, true)) {
            return;
        }

        $this->session->put(static::PAGE_NAME, $request->getPathInfo());
    }
}
