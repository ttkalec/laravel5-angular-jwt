<?php

use App\User;
use Illuminate\Http\Response as HttpResponse;

//Route::controllers([
//	'auth' => 'Auth\AuthController',
//	'password' => 'Auth\PasswordController',
//]);

Route::get('/', function () {
    return view('spa');
});

Route::post('/signup', function () {
    // Validate input

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