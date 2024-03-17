<style>
.is-invalid~.invalid-feedback {
    display: block;
}
</style>

<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">
            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <a href="#" class="noble-ui-logo logo-light d-block mb-2">{{ Helper::websiteName() }}</a>
                                    <h5 class="text-muted fw-normal mb-4">{{ __( 'auth.login_description' ) }}</h5>
                                    <form class="forms-sample" method="POST" action="{{ route('web.login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">{{ __( 'auth.username_label' ) }}</label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="{{ __( 'auth.username_label' ) }}">
                                            @error( 'username' )
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">{{ __( 'auth.password_label' ) }}</label>
                                            <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" placeholder="{{ __( 'auth.password_label' ) }}">
                                        </div>
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="authCheck" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="authCheck">
                                            {{ __( 'auth.remember_me' ) }}
                                            </label>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary me-2 mb-2 mb-md-0 text-white w-100">{{ __( 'auth.login' ) }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>