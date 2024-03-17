<?php
$maintenance_create = 'maintenance_create';
?>

@if ( Session::has( 'error' ) )
<div class="alert alert-danger" role="alert">
    <div class="d-flex align-items-center">
        <i icon-name="alert-circle"></i>
        <strong>{{ __( 'template.error' ) }}</strong> {{ Session::get( 'error' ) }}
    </div>        
</div>
@endif

<h3>{{ __( 'maintenance.maintenance_create' ) }}</h3>
<br>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="card-title">{{ __( 'maintenance.maintenance_detail' ) }}</h6>
                <form action="{{ route('admin.maintenance.create_') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="{{ $maintenance_create }}_type" class="col-sm-3 col-form-label">{{ __( 'maintenance.type' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'type' ) is-invalid @enderror" id="{{ $maintenance_create }}_type" name="type">
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
                        <label for="{{ $maintenance_create }}_start_date" class="col-sm-3 col-form-label">{{ __( 'maintenance.start_date' ) }}</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control form-control-sm @error( 'start_date' ) is-invalid @enderror" id="{{ $maintenance_create }}_start_date" 
                            name="start_date" placeholder="{{ __( 'maintenance.start_date' ) }}" value="">
                            @error( 'start_date' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $maintenance_create }}_end_date" class="col-sm-3 col-form-label">{{ __( 'maintenance.end_date' ) }}</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control form-control-sm @error( 'end_date' ) is-invalid @enderror" id="{{ $maintenance_create }}_end_date" 
                            name="end_date" placeholder="{{ __( 'maintenance.end_date' ) }}" value="">
                            @error( 'end_date' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $maintenance_create }}_start_time" class="col-sm-3 col-form-label">{{ __( 'maintenance.start_time' ) }}</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control form-control-sm @error( 'start_time' ) is-invalid @enderror" id="{{ $maintenance_create }}_start_time" 
                            name="start_time" placeholder="{{ __( 'maintenance.start_time' ) }}" value="">
                            @error( 'start_time' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $maintenance_create }}_end_time" class="col-sm-3 col-form-label">{{ __( 'maintenance.end_time' ) }}</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control form-control-sm @error( 'end_time' ) is-invalid @enderror" id="{{ $maintenance_create }}_end_time" 
                            name="end_time" placeholder="{{ __( 'maintenance.end_time' ) }}" value="">
                            @error( 'end_time' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $maintenance_create }}_content" class="col-sm-3 col-form-label">{{ __( 'maintenance.content' ) }}</label>
                        <div class="col-sm-9">
                            <textarea rows="10" class="form-control form-control-sm @error( 'content' ) is-invalid @enderror" id="{{ $maintenance_create }}_content" name="content" placeholder="{{ __( 'maintenance.content' ) }}">{{ old( 'content' ) }}</textarea>
                            @error( 'content' )
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