
<?php

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {
    protected $routeMiddleware = [
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
    ];
}
