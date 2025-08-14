@extends('layouts.guest')

@section('content')
<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper bg-img">
            <div class="login-content">
                <form  method="POST" action="{{ route('login') }}" class="row g-3">
                    @csrf
                    <div class="login-userset">
                        <div class="login-logo logo-normal">
                           <img src="{{ asset('assets/icon/5.png') }}" alt="img">
                       </div>
                       <a href="#" class="login-logo logo-white">
                           <img src="{{ asset('assets/icon/5.png') }}"  alt="">
                       </a>
                       <div class="login-userheading">
                           <h3>Commencer maintenant</h3>
                           <h4>Saisissez vos identifiants pour vous connecter !</h4>
                       </div>
                       <div class="form-login mb-3">
                           <label class="form-label">{{ __('Adresse e-mail') }}</label>
                           <div class="form-addons">
                               <input placeholder="Saisissez votre adresse e-mail" id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                               @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                           </div>
                       </div>


                       <div class="form-login mb-3">
                           <label class="form-label">{{ __('Mot de passe') }}</label>
                           <div class="pass-group">
                               <input placeholder="**********" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                               @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               <span class="fas toggle-password fa-eye-slash"></span>
                           </div>
                       </div>
                       <div class="form-login authentication-check">
                           <div class="row">
                               <div class="col-12 d-flex align-items-center justify-content-between">
                                   <div class="custom-control custom-checkbox">
                                       <label class="checkboxs ps-4 mb-0 pb-0 line-height-1">
                                           <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                           <span class="checkmarks"></span>{{ __('Se souvenir de moi') }}
                                       </label>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="form-login">
                           <button type="submit" class="btn btn-login">Se connecter</button>
                       </div>
                   </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
