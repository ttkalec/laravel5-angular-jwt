<?php

use App\User;
use Illuminate\Http\Response as HttpResponse;

/**
 * Displays Angular SPA application
 */
Route::get('/', function () {
    return view('spa');
});

/**
 * Registers a new user and returns a auth token
 */
Route::post('/signup', function () {
    $credentials = Input::only('email', 'password');

    try {
        $user = User::create($credentials);
    } catch (Exception $e) {
        return Response::json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);
    }

    $token = JWTAuth::fromUser($user);

    return Response::json(compact('token'));
});

/**
 * Signs in a user using JWT
 */
Route::post('/signin', function () {
    $credentials = Input::only('email', 'password');

    if (!$token = JWTAuth::attempt($credentials)) {
        return Response::json(false, HttpResponse::HTTP_UNAUTHORIZED);
    }

    return Response::json(compact('token'));
});


/**
 * Fetches a restricted resource from the same domain used for user authentication
 */
Route::get('/restricted', [
    'before' => 'jwt-auth',
    function () {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        return Response::json([
            'data' => [
                'email' => $user->email,
                'registered_at' => $user->created_at->toDateTimeString()
            ]
        ]);
    }
]);

/**
 * Fetches a restricted resource from API subdomain using CORS
 */
Route::group(['domain' => 'api.jwt.dev', 'prefix' => 'v1'], function () {
    Route::get('/restricted', function () {
        try {
            JWTAuth::parseToken()->toUser();
        } catch (Exception $e) {
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }

        return ['data' => 'This has come from a dedicated API subdomain with restricted access.'];
    });
});