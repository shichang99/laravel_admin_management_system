<?php
$maintenance_modify = 'maintenance_modify';
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
                <h6 class="card-title">{{ __( 'maintenance.maintenance_detail' ) }}</h6>
                <form action="{{ route('admin.maintenance.update') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="encrypted_id" value="{{ request()->get( 'id' ) }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="{{ $maintenance_modify }}_type" class="col-sm-3 col-form-label">{{ __( 'maintenance.type' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'type' ) is-invalid @enderror" id="{{ $maintenance_modify }}_type" name="type" disabled>
                                @foreach ( $data['types'] as $type )
                                <?php
                                $selectedID = 0;
                                if ( old( 'type' ) ) {
                                    $selectedID = old( 'type' );
                                } else {
                                    $selectedID = $data['maintenance']['type'];
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
                        <label for="{{ $maintenance_modify }}_start_date" class="col-sm-3 col-form-label">{{ __( 'maintenance.start_date' ) }}</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control form-control-sm @error( 'start_date' ) is-invalid @enderror" id="{{ $maintenance_modify }}_start_date" 
                            name="start_date" placeholder="{{ __( 'maintenance.start_date' ) }}" 
                            value="{{ old( 'start_date' ) ? old( 'start_date' ) : $data['maintenance']['start_date'] }}">
                            @error( 'start_date' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $maintenance_modify }}_end_date" class="col-sm-3 col-form-label">{{ __( 'maintenance.end_date' ) }}</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control form-control-sm @error( 'end_date' ) is-invalid @enderror" id="{{ $maintenance_modify }}_end_date" 
                            name="end_date" placeholder="{{ __( 'maintenance.end_date' ) }}" 
                            value="{{ old( 'end_date' ) ? old( 'end_date' ) : $data['maintenance']['end_date'] }}">
                            @error( 'end_date' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $maintenance_modify }}_start_time" class="col-sm-3 col-form-label">{{ __( 'maintenance.start_time' ) }}</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control form-control-sm @error( 'start_time' ) is-invalid @enderror" id="{{ $maintenance_modify }}_start_time" 
                            name="start_time" placeholder="{{ __( 'maintenance.start_time' ) }}" 
                            value="{{ old( 'start_time' ) ? old( 'start_time' ) : $data['maintenance']['start_time'] }}">
                            @error( 'start_time' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $maintenance_modify }}_end_time" class="col-sm-3 col-form-label">{{ __( 'maintenance.end_time' ) }}</label>
                        <div class="col-sm-9">
                            <input type="time" class="form-control form-control-sm @error( 'end_time' ) is-invalid @enderror" id="{{ $maintenance_modify }}_end_time" 
                            name="end_time" placeholder="{{ __( 'maintenance.end_time' ) }}" 
                            value="{{ old( 'end_time' ) ? old( 'end_time' ) : $data['maintenance']['end_time'] }}">
                            @error( 'end_time' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $maintenance_modify }}_content" class="col-sm-3 col-form-label">{{ __( 'maintenance.content' ) }}</label>
                        <div class="col-sm-9">
                            <textarea rows="10" class="form-control form-control-sm @error( 'content' ) is-invalid @enderror" id="{{ $maintenance_modify }}_content" 
                            name="content" placeholder="{{ __( 'maintenance.content' ) }}">{{old( 'content' ) ? old( 'content' ) : $data['maintenance']['content'] }}
                            </textarea>
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