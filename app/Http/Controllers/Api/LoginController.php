<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        if (Auth::once($request->validated())) {
            /** @var User */
            $user = User::where('email', $request->input('email'))->first();

            return Response::json(LoginResource::make($user), 201);
        }

        throw ValidationException::withMessages(['email' => __('auth.failed')]);
    }
}
