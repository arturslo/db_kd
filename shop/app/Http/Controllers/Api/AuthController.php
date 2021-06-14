<?php

namespace App\Http\Controllers\Api;

use App\Client\Client;
use App\Client\ClientRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request, ClientRepository $clientRepository)
    {
        $rules = [
            'Firstname' => 'required',
            'Lastname' => 'required',
            'Email' => 'required|unique:Client|email:rfc,dns',
            'Password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $validated = $validator->validate();
        $client = new Client(...$validated);

        $client->ClientId = $clientRepository->create($client);

        return $client;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, ClientRepository $clientRepository)
    {
        $credentials = request(['Email', 'Password']);

        $client = $clientRepository->findByEmailAndPassword($request->input('Email'), $request->input('Password'));
//        $client = $clientRepository->findByEmailAndPassword('annak@gmail.com', 'qwerty');

        if (!$client) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = auth('api')->login($client);

        return $this->makeResponse($token, $client);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $client = auth('api')->user();
        return $this->makeResponse(auth('api')->refresh(), $client);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function makeResponse($token, $client)
    {
        $expiresSec = auth('api')->factory()->getTTL() * 60;

        return response()->json([
            'accessToken' => $token,
            'tokenType' => 'bearer',
            'expiresIn' => $expiresSec,
            'id' => $client->ClientId,
            'email' => $client->Email,
            'name' => $client->getName(),
        ]);
    }
}
