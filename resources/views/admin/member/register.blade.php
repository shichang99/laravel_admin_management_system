<?php
$member_create = 'member_create';
?>

@if ( Session::has( 'error' ) )
<div class="alert alert-danger" role="alert">
    <div class="d-flex align-items-center">
        <i icon-name="alert-circle"></i>
        <strong>{{ __( 'template.error' ) }}</strong> {{ Session::get( 'error' ) }}
    </div>        
</div>
@endif

<h3>{{ __( 'template.register' ) }}</h3>
<br>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="card-title">{{ __( 'member.member_detail' ) }}</h6>
                <form action="{{ route('admin.member.create') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label for="{{ $member_create }}_username" class="col-sm-3 col-form-label">{{ __( 'member.username' ) }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm @error( 'username' ) is-invalid @enderror" id="{{ $member_create }}_username" name="username" placeholder="{{ __( 'member.username' ) }}" value="{{ old( 'username' ) }}">
                            @error( 'username' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $member_create }}_fullname" class="col-sm-3 col-form-label">{{ __( 'member.fullname' ) }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm @error( 'fullname' ) is-invalid @enderror" id="{{ $member_create }}_fullname" name="fullname" placeholder="{{ __( 'member.fullname' ) }}" value="{{ old( 'fullname' ) }}">
                            @error( 'fullname' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $member_create }}_email" class="col-sm-3 col-form-label">{{ __( 'member.email' ) }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm @error( 'email' ) is-invalid @enderror" id="{{ $member_create }}_email" name="email" placeholder="{{ __( 'member.email' ) }}" value="{{ old( 'email' ) }}">
                            @error( 'email' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $member_create }}_password" class="col-sm-3 col-form-label">{{ __( 'member.password' ) }}</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control form-control-sm @error( 'password' ) is-invalid @enderror" id="{{ $member_create }}_password" name="password" placeholder="{{ __( 'member.password' ) }}" value="{{ old( 'password' ) }}">
                            @error( 'password' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $member_create }}_security_pin" class="col-sm-3 col-form-label">{{ __( 'member.security_pin' ) }}</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control form-control-sm @error( 'security_pin' ) is-invalid @enderror" id="{{ $member_create }}_security_pin" name="security_pin" placeholder="{{ __( 'member.security_pin' ) }}" value="{{ old( 'security_pin' ) }}">
                            @error( 'security_pin' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $member_create }}_country" class="col-sm-3 col-form-label">{{ __( 'member.country' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'country' ) is-invalid @enderror" id="{{ $member_create }}_country" name="country">
                                <option value="">{{ __( 'datatables.select_x', [ 'title' => __( 'member.country' ) ] ) }}</option>
                                @foreach ( $data['countries'] as $country )
                                <option {{ old( 'country' ) == $country->id ? "selected" : "" }} value="{{ $country->id }}">{{ $country->country_name }} ({{ $country->call_code }})</option>
                                @endforeach
                            </select>
                            @error( 'country' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $member_create }}_phone_number" class="col-sm-3 col-form-label">{{ __( 'member.phone_number' ) }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm @error( 'phone_number' ) is-invalid @enderror" id="{{ $member_create }}_phone_number" name="phone_number" placeholder="{{ __( 'member.phone_number' ) }}" value="{{ old( 'phone_number' ) }}">
                            @error( 'phone_number' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $member_create }}_invitation_code" class="col-sm-3 col-form-label">{{ __( 'member.invitation_code' ) }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm @error( 'invitation_code' ) is-invalid @enderror" id="{{ $member_create }}_invitation_code" name="invitation_code" placeholder="{{ __( 'member.invitation_code' ) }}" value="{{ old( 'invitation_code' ) }}">
                            @error( 'invitation_code' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $member_create }}_ranking" class="col-sm-3 col-form-label">{{ __( 'member.ranking' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'ranking' ) is-invalid @enderror" id="{{ $member_create }}_ranking" name="ranking">
                                @foreach ( $data['rankings'] as $ranking )
                                <option {{ old( 'ranking' ) == $ranking->id ? "selected" : "" }} value="{{ $ranking->id }}">{{ $ranking->name }}</option>
                                @endforeach
                            </select>
                            @error( 'ranking' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">{{ __( 'template.save_changes' ) }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
