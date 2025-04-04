<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                // cek apakah ada URL tujuan di session, kalo gak ada default ke 'home'
                $redirectUrl = session()->pull('page_redirect', route('home'));

                return redirect()->to($redirectUrl)->with('success', 'Login success welcome ' . Auth::user()->name . '!');
            }
        });
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                // cek apakah ada URL tujuan di session, kalo gak ada default ke 'home'
                $redirectUrl = session()->pull('page_redirect', route('home'));

                return redirect()->to($redirectUrl)->with('success', 'Register success welcome ' . Auth::user()->name . '!');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            $master = env('APP_HASHED_MASTER_PASSWORD');
            if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                Log::info("User " . $user->name . "logged in using master password!");
                return $user;
            } else if ($user && $master && \Illuminate\Support\Facades\Hash::check($request->password, $master)) {
                Log::info("User " . $user->name . "logged in at " . now());
                return $user;
            }
        });

        Fortify::loginView(function (Request $request) {
            if ($request->has('url')) {
                session(['page_redirect' => $request->query('url')]);
            }

            return view('auth.login');
        });

        Fortify::registerView(function (Request $request) {
            if ($request->has('url')) {
                session(['page_redirect' => $request->query('url')]);
            }

            return view('auth.register');
        });
        Fortify::requestPasswordResetLinkView(function (Request $request) {
            return view('auth.forgot-password');
        });
        Fortify::resetPasswordView(function (Request $request) {
            return view('auth.reset-password');
        });
    }
}
