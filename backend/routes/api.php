<?php
    use App\Facade\Route;
    use App\Http\Response;
    use App\Http\Controllers\PostController;

    Route::get('/', function () {
    $response = new Response();
    
    $response->status(200)
        ->json([
            'success' => true,
            'message' => 'Bienvenue sur mon API 😁😁'
        ])->send();
    });

    Route::get('/api/posts', [PostController::class, 'index']);
    Route::get('/api/posts/{id}', [PostController::class, 'show']);
    Route::post('/api/posts', [PostController::class, 'store']);
    Route::put('/api/posts/{id}', [PostController::class, 'update']);
    Route::delete('/api/posts/{id}', [PostController::class, 'destroy']);