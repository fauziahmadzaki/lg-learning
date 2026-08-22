<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\ConfirmPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordController extends Controller
{
    public function __construct(
        private AuthService $authService,
    ) {}

    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(ForgotPasswordRequest $request): RedirectResponse
    {
        $status = $this->authService->sendResetLink($request->input('email'));

        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $status = $this->authService->resetPassword(
            $request->input('email'),
            $request->input('password'),
            $request->input('token'),
        );

        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }

    public function showConfirmPassword(): View
    {
        return view('auth.confirm-password');
    }

    public function confirmPassword(ConfirmPasswordRequest $request): RedirectResponse
    {
        $this->authService->confirmPassword($request->user(), $request->input('password'));

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $this->authService->updatePassword(
            $request->user(),
            $request->input('password'),
        );

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
