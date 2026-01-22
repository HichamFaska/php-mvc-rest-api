<?php
    require dirname(__DIR__)."/vendor/autoload.php";

    use App\Http\Request;
    use App\Facade\Route;
    use App\Core\Router;

    $request = Request::capture();
    $router = new Router();

    Route::setRouter($router);

    require dirname(__DIR__)."/routes/api.php";
    $router->dispatch($request);