@extends('layouts.session')
@section('meta.title', 'Giriş Yap')


@section('content')
    <div class="auth-layout-wrap" style="background-image: url({{ asset('storage/template/dist-assets/images/photo-wide-4.jpg') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4"><img src="{{ asset('storage/template/dist-assets/images/logo.png') }}" alt=""></div>
                            <h1 class="mb-3 text-18">Sign In</h1>
                            <form method="POST" action="{{ route('login') }}" class="ajax">
                                <div class="form-group">
                                    <label for="email">E-Posta Adresi</label>
                                    <input class="form-control form-control-rounded" name="email" id="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="password">Şifre</label>
                                    <input class="form-control form-control-rounded" id="password" name="password" type="password">
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label" for="remember">
                                          Beni Hatırla
                                        </label>
                                    </div>
                                </div>

                                <button class="btn btn-rounded btn-primary btn-block mt-2 ajax_btn" type="submit">Giriş Yap</button>
                            </form>
                            <div class="mt-3 text-center"><a class="text-muted" href="{{ route('password.request') }}">
                                    <u>Şifremi Unuttum</u></a></div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{ asset('storage/template/dist-assets/images/photo-long-3.jpg') }})">
                        <div class="pr-3 auth-right">
                            <a class="btn btn-rounded btn-outline-primary btn-outline-email btn-block btn-icon-text" href="{{ route('register') }}">
                                <i class="i-Mail-with-At-Sign"></i> Üye Ol</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
