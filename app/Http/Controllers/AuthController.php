<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;

#[OA\PathItem(
    path: "/api/auth"
)]
class AuthController extends Controller
{
    #[OA\Post(
        path: "/api/auth/login",
        operationId: "login",
        tags: ["Auth"],
        summary: "User login",
        description: "Logs in a user",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ["email", "password"],
                    properties: [
                        new OA\Property(property: "email", type: "string"),
                        new OA\Property(property: "password", type: "string"),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Successful login"),
            new OA\Response(response: 401, description: "Invalid credentials"),
        ]
    )]
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (auth()->attempt($data)) {
            if (!auth()->user()->hasVerifiedEmail()) {
                auth()->logout();
                return back()->with('error', 'You need to verify your email address before logging in.');
            }
            return redirect()->route('home')->with('success', 'You have been logged in!');
        }
        return back()->with('error', 'Invalid credentials');
    }

    #[OA\Post(
        path: "/api/auth/logout",
        operationId: "logout",
        tags: ["Auth"],
        summary: "User logout",
        description: "Logs out a user",
        responses: [
            new OA\Response(response: 200, description: "Successful logout"),
        ]
    )]
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out!');
    }

    #[OA\Post(
        path: "/api/auth/forgot-password",
        operationId: "forgotPassword",
        tags: ["Auth"],
        summary: "Forgot password",
        description: "Sends a password reset link",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Password reset link sent"),
        ]
    )]
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}