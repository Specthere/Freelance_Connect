<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // middleware lainnya...
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'client' => \App\Http\Middleware\ClientMiddleware::class,
        'freelancer' => \App\Http\Middleware\FreelancerMiddleware::class,
        'guest' => \App\Http\Middleware\GuestMiddleware::class,
    ];

    /**
     * The application's route middleware aliases.
     *
     * Aliases may be used instead of class names to assign middleware to routes and groups.
     *
     * @var array
     */
    protected $middlewareAliases = [
        // middleware lainnya...
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'client' => \App\Http\Middleware\ClientMiddleware::class,
        'freelancer' => \App\Http\Middleware\FreelancerMiddleware::class,
        'guest' => \App\Http\Middleware\GuestMiddleware::class,
    ];
} 