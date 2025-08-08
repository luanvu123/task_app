<!doctype html>
<html class="no-js" lang="vi" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Đăng nhập</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- project css file -->
    <link rel="stylesheet" href="{{ asset('assets/css/my-task.style.min.css') }}">
</head>

<body data-mytask="theme-indigo">
    <div id="mytask-layout">
        <!-- main body area -->
        <div class="main p-2 py-3 p-xl-5 ">
            <!-- Body -->
            <div class="body d-flex p-0 p-xl-5">
                <div class="container-xxl">
                    <div class="row g-0">
                        <!-- Left image/illustration -->
                        <div
                            class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">
                            <div style="max-width: 25rem;">
                                <div class="text-center mb-5">
                                    <svg width="4rem" fill="currentColor" class="bi bi-clipboard-check"
                                        viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                        <path
                                            d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                        <path
                                            d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                    </svg>
                                </div>
                                <div class="mb-5">
                                    <h2 class="color-900 text-center">My-Task - Quản lý hiệu quả hơn</h2>
                                </div>
                                <div>
                                    <img src="{{ asset('assets/images/login-img.svg') }}" alt="Hình đăng nhập">
                                </div>
                            </div>
                        </div>

                        <!-- Right form -->
                        <div
                            class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
                            <div class="w-100 p-3 p-md-5 card border-0 bg-dark text-light" style="max-width: 32rem;">
                                <!-- Laravel Login Form -->
                                <form method="POST" action="{{ route('login') }}" class="row g-1 p-3 p-md-4">
                                    @csrf
                                    <div class="col-12 text-center mb-1 mb-lg-5">
                                        <h1>Đăng nhập</h1>
                                        <span>Truy cập miễn phí vào bảng điều khiển.</span>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label">Địa chỉ Email</label>
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                                placeholder="nhapemail@vidu.com" required autofocus>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-2">
                                            <div class="form-label">
                                                <span class="d-flex justify-content-between align-items-center">
                                                    Mật khẩu
                                                    @if (Route::has('password.request'))
                                                        <a class="text-secondary" href="{{ route('password.request') }}">
                                                            Quên mật khẩu?
                                                        </a>
                                                    @endif
                                                </span>
                                            </div>
                                            <input type="password" name="password"
                                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                placeholder="Nhập mật khẩu" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="flexCheckDefault" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Ghi nhớ đăng nhập
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 text-center mt-4">
                                        <button type="submit"
                                            class="btn btn-lg btn-block btn-light lift text-uppercase">
                                            Đăng nhập
                                        </button>
                                    </div>

                                    {{-- <div class="col-12 text-center mt-4">
                                        @if (Route::has('register'))
                                            <span class="text-muted">
                                                Chưa có tài khoản?
                                                <a href="{{ route('register') }}" class="text-secondary">Đăng ký ngay</a>
                                            </span>
                                        @endif
                                    </div> --}}
                                </form>
                                <!-- End Form -->
                            </div>
                        </div>
                    </div> <!-- End Row -->
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
</body>

</html>
