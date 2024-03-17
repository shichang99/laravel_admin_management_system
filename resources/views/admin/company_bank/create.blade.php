<?php
$company_bank_create = 'company_bank_create';
?>

@if ( Session::has( 'error' ) )
<div class="alert alert-danger" role="alert">
    <div class="d-flex align-items-center">
        <i icon-name="alert-circle"></i>
        <strong>{{ __( 'template.error' ) }}</strong> {{ Session::get( 'error' ) }}
    </div>        
</div>
@endif

<h3>{{ __( 'company_bank.company_bank_create' ) }}</h3>
<br>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="card-title">{{ __( 'company_bank.company_bank_detail' ) }}</h6>
                <form action="{{ route('admin.company_bank.create_') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="{{ $company_bank_create }}_type" class="col-sm-3 col-form-label">{{ __( 'company_bank.type' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'type' ) is-invalid @enderror" id="{{ $company_bank_create }}_type" name="type">
                                @foreach ( $data['types'] as $type )
                                <option {{ old( 'type' ) == $type['value'] ? "selected" : "" }} value="{{ $type['value'] }}">{{ $type['title'] }}</option>
                                @endforeach
                            </select>
                            @error( 'type' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $company_bank_create }}_number" class="col-sm-3 col-form-label">{{ __( 'company_bank.number' ) }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm @error( 'number' ) is-invalid @enderror" id="{{ $company_bank_create }}_number" name="number" placeholder="{{ __( 'company_bank.number' ) }}" value="{{ old( 'number' ) }}">
                            @error( 'number' )
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