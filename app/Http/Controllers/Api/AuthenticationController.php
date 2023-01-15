<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || Hash::check($request->input('password'), $user->password)){
            throw ValidationException::withMessages([
                "email" => ['The provided credentials are incorrect.']
            ]);
        }

        return response()->json([
            "message" => "Login berhasil.",
            "token" => $user->createToken('Sanctum token for ' . $user->name)->plainTextToken
        ]);
    }
}
