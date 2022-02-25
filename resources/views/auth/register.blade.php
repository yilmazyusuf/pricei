@extends('layouts.session')
@section('meta.title', 'Üye Ol')


@section('content')
    <div class="auth-layout-wrap" style="background-image: url({{ asset('storage/template/dist-assets/images/photo-wide-4.jpg') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{ asset('storage/template/dist-assets/images/photo-long-3.jpg') }})">
                        <div class="pl-3 auth-right">
                            <div class="auth-logo text-center mt-4"><img src="{{ asset('storage/template/dist-assets/images/logo.png') }}" alt=""></div>
                            <div class="flex-grow-1"></div>
                            <div class="w-100 mb-4">
                                <a class="btn btn-outline-primary btn-block btn-icon-text btn-rounded" href="{{ route('login') }}"><i class="i-Mail-with-At-Sign"></i> Giriş Yap</a>
                            </div>
                            <div class="flex-grow-1"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4">
                            <h1 class="mb-3 text-18">Üyelik</h1>
                            <form  class="ajax" method="POST" action="{{ route('register') }}">
                                <div class="form-group">
                                    <label for="name">İsim Soyisim</label>
                                    <input id="name" type="text" class="form-control form-control-rounded" name="name"   autocomplete="name" autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="email">E-Posta Adresi</label>
                                    <input id="email" type="email" class="form-control form-control-rounded" name="email"  autocomplete="email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Şifre</label>
                                    <input id="password" type="password" class="form-control form-control-rounded" name="password"  autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">Şifre Tekrarı</label>
                                    <input id="password-confirm" type="password" class="form-control form-control-rounded" name="password_confirmation"  autocomplete="new-password">
                                </div>
                                <button class="btn btn-primary btn-block btn-rounded mt-3 ajax_btn" type="submit">Üye Ol</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
