@extends('components.layouts.auth')

@section('title', 'Login')

@section('content')
    <img src="{{ asset('assets/img/landing/wallpaper_legends_cover_1920x1080.png') }}" alt=""
        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="filter: brightness(0.5)">
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6">
                <!-- Login -->
                <div class="card" style="background-color: rgba(var(--bs-body-bg-rgb), 0.7); backdrop-filter: blur(10px);">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{ route('landing.index') }}" class="app-brand-link">
                                <svg width="35" height="39" viewBox="0 0 35 39" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M30.2856 0.81323L16.7262 14.6689C16.6584 14.7382 16.5475 14.7388 16.4789 14.6703L11.9667 10.1605C11.8867 10.0806 11.9021 9.94639 11.9982 9.88685L12.9981 9.26688C13.1477 9.1741 13.0823 8.9422 12.9065 8.9422H0.877187C0.721446 8.9422 0.643764 9.1318 0.754318 9.2421L11.3708 19.8336C11.4397 19.9023 11.4395 20.0144 11.3704 20.0829L2.78824 28.5994C2.75503 28.6323 2.73633 28.6773 2.73633 28.7242V38.5847C2.73633 38.7409 2.92397 38.8192 3.03394 38.709L30.5331 11.1452C30.5659 11.1123 30.5843 11.0676 30.5843 11.021V0.936246C30.5843 0.7793 30.395 0.701358 30.2856 0.81323Z"
                                        fill="var(--bs-heading-color)" />
                                    <path
                                        d="M18.1939 26.0786L23.0274 21.2189C23.0958 21.1501 23.2068 21.1504 23.2748 21.2196L32.559 30.6641C32.6679 30.7749 32.5898 30.9628 32.4349 30.9628H20.3413C20.1732 30.9628 20.1024 30.7472 20.2374 30.6465L21.3082 29.8483C21.3929 29.7852 21.403 29.6616 21.3297 29.5855L18.1919 26.3246C18.1257 26.2558 18.1266 26.1463 18.1939 26.0786Z"
                                        fill="var(--bs-heading-color)" />
                                    <path
                                        d="M34.528 36.0693L27.694 36.0694C27.598 36.0694 27.52 35.9913 27.5196 35.8948L27.5051 32.7606H32.4349C34.1778 32.7606 35.0559 30.6466 33.8307 29.4003L27.4597 22.9193L27.4407 18.7972C27.4402 18.6904 27.3457 18.6088 27.2406 18.6245L25.9245 18.821C25.7582 18.8459 25.6566 18.6431 25.7755 18.5235L34.3258 9.92658C34.4355 9.81627 34.6232 9.89407 34.6236 10.0501L34.7024 35.8934C34.7027 35.9905 34.6245 36.0693 34.528 36.0693Z"
                                        fill="var(--bs-heading-color)" />
                                </svg>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 minecraft-ten-v2">Welcome to {{ config('app.name') }}!</h4>
                        <p class="mb-6">Please sign-in to your account and start your adventure!</p>

                        <form id="formAuthentication" class="mb-4" action="{{ route('login.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="url" value="{{ request('url') }}">
                            <div class="mb-6 form-control-validation">
                                <label for="email" class="form-label">Email </label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" autofocus value="superadmin@gmail.com" />
                            </div>
                            <div class="mb-6 form-password-toggle form-control-validation">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" value="superadmin" />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base ti tabler-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="my-7">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check mb-0 ms-2">
                                        <input class="form-check-input" type="checkbox" id="remember-me" />
                                        <label class="form-check-label" for="remember-me"> Remember Me </label>
                                    </div>
                                    <a href="{{ route('password.request') }}">
                                        <p class="mb-0">Forgot Password?</p>
                                    </a>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                            <div class="divider">
                                <div class="divider-text">or</div>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('register') }}">Join now!</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>
@endsection
