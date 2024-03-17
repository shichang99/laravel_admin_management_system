<?php
$company_bank_modify = 'company_bank_modify';
?>

@if ( Session::has( 'error' ) )
<div class="alert alert-danger" role="alert">
    <div class="d-flex align-items-center">
        <i icon-name="alert-circle"></i>
        <strong class="me-2">{{ __( 'template.error' ) }}</strong>{{ Session::get( 'error' ) }}
    </div>        
</div>
@endif

<h3>{{ __( 'template.modify' ) }}</h3>
<br>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="card-title">{{ __( 'company_bank.company_bank_detail' ) }}</h6>
                <form action="{{ route('admin.company_bank.update') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="encrypted_id" value="{{ request()->get( 'id' ) }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="{{ $company_bank_modify }}_type" class="col-sm-3 col-form-label">{{ __( 'company_bank.type' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'type' ) is-invalid @enderror" id="{{ $company_bank_modify }}_type" name="type">
                                @foreach ( $data['types'] as $type )
                                <?php
                                $selectedID = 0;
                                if ( old( 'type' ) ) {
                                    $selectedID = old( 'type' );
                                } else {
                                    $selectedID = $data['company_bank']['type'];
                                }
                                ?>
                                <option {{ $selectedID == $type['value'] ? "selected" : "" }} value="{{ $type['value'] }}">{{ $type['title'] }}</option>
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
                        <label for="{{ $company_bank_modify }}_is_primary" class="col-sm-3 col-form-label">{{ __( 'company_bank.is_primary' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'is_primary' ) is-invalid @enderror" id="{{ $company_bank_modify }}_is_primary" name="is_primary">
                                {{ $data['company_bank']['is_primary']; }}
                                @foreach ( $data['is_primaries'] as $is_primary )
                                <?php
                                $selectedID = 0;
                                if ( old( 'is_primary' ) ) {
                                    $selectedID = old( 'is_primary' );
                                } else {
                                    $selectedID = $data['company_bank']['is_primary'];
                                }
                                ?>
                                <option {{ $selectedID == $is_primary['value'] ? "selected" : "" }} value="{{ $is_primary['value'] }}">{{ $is_primary['title'] }}</option>
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
                        <label for="{{ $company_bank_modify }}_number" class="col-sm-3 col-form-label">{{ __( 'company_bank.number' ) }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm @error( 'number' ) is-invalid @enderror" id="{{ $company_bank_modify }}_number" 
                            name="number" placeholder="{{ __( 'company_bank.number' ) }}" 
                            value="{{ old( 'number' ) ? old( 'number' ) : $data['company_bank']['number'] }}">
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