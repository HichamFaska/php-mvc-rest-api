<?php
    use App\Facade\Route;
    use App\Http\Response;

    Route::get('/', function () {
    $response = new Response();
    
    $response->status(200)
        ->json([
            'success' => true,
            'message' => 'Bienvenue sur mon API 😁😁'
        ])->send();
    });