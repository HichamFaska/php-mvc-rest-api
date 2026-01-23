<?php
    require dirname(__DIR__)."/vendor/autoload.php";

    use App\Core\Env;
    use App\Http\Request;
    use App\Http\Response;
    use App\Facade\Route;
    use App\Core\Router;

    Env::load(__DIR__."/../.env");

    $request = Request::capture();
    
    // Gérer les requêtes OPTIONS (preflight CORS)
    if($request->method() === 'OPTIONS'){
        $response = new Response();
        $response->cors()->status(200)->send();
        exit;
    }

    $router = new Router();

    Route::setRouter($router);

    require dirname(__DIR__)."/routes/api.php";
    $router->dispatch($request);