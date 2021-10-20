<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($user = $request->user()) {
            $user->currentAccessToken()->delete();

            return Response::noContent();
        }
    }
}
