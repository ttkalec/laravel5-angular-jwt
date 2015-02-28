<?php

use App\User;
use Illuminate\Http\Response as HttpResponse;

Route::get('/', function () {
    return view('spa');
});

Route::post('/signup', function () {
    $credentials = Input::only('email', 'password');
    $user = User::create($credentials);

    $token = JWTAuth::fromUser($user);
    return Response::json(compact('token'));
});

Route::post('/signin', function () {
    $credentials = Input::only('email', 'password');

    if ( ! $token = JWTAuth::attempt($credentials) )
    {
        return Response::json(false, HttpResponse::HTTP_UNAUTHORIZED);
    }

    return Response::json(compact('token'));
});

Route::get('/restricted', ['before' => 'jwt-auth', function () {
    $token = JWTAuth::getToken();
    $user = JWTAuth::toUser($token);

    return Response::json(['data' => [
        'email' => $user->email,
        'registered_at' => $user->created_at->toDateTimeString()
    ]]);
}]);

Route::group(['domain' => 'api.jwt.dev', 'prefix' => 'v1'], function()
{
    Route::get('/restricted', function()
    {
        try
        {
            $user = JWTAuth::parseToken()->toUser();
        }
        catch(Exception $e)
        {
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }

        return ['data' => 'This has come from a dedicated API subdomain with restricted access.'];
    });
});