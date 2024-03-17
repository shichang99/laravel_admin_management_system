<?php
$announcement_create = 'announcement_create';

// var_dump($data['languages']);
// exit;
?>

@if ( Session::has( 'error' ) )
<div class="alert alert-danger" role="alert">
    <div class="d-flex align-items-center">
        <i icon-name="alert-circle"></i>
        <strong>{{ __( 'template.error' ) }}</strong> {{ Session::get( 'error' ) }}
    </div>        
</div>
@endif

<h3>{{ __( 'announcement.announcement_create' ) }}</h3>
<br>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="card-title">{{ __( 'announcement.announcement_detail' ) }}</h6>
                <form action="{{ route('admin.announcement.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="{{ $announcement_create }}_language" class="col-sm-3 col-form-label">{{ __( 'announcement.language' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'language' ) is-invalid @enderror" id="{{ $announcement_create }}_language" name="language">
                                @foreach ( $data['languages'] as $language )
                                <?php
                                $selectedID = 0;
                                if ( old( 'language' ) ) {
                                    $selectedID = old( 'language' );
                                } else {
                                    $selectedID = app()->getLocale();
                                }
                                ?>

                                <option {{ $selectedID == $language['value'] ? "selected" : "" }} value="{{ $language['value'] }}">{{ $language['title'] }}</option>
                                @endforeach
                            </select>
                            @error( 'language' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $announcement_create }}_type" class="col-sm-3 col-form-label">{{ __( 'announcement.type' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'type' ) is-invalid @enderror" id="{{ $announcement_create }}_type" name="type">
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
                        <label for="{{ $announcement_create }}_title" class="col-sm-3 col-form-label">{{ __( 'announcement.title' ) }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm @error( 'title' ) is-invalid @enderror" id="{{ $announcement_create }}_title" name="title" placeholder="{{ __( 'announcement.title' ) }}" value="{{ old( 'username' ) }}">
                            @error( 'title' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $announcement_create }}_message" class="col-sm-3 col-form-label">{{ __( 'announcement.message' ) }}</label>
                        <div class="col-sm-9">
                            <textarea rows="20" class="form-control form-control-sm @error( 'message' ) is-invalid @enderror" id="{{ $announcement_create }}_message" name="message" placeholder="{{ __( 'announcement.message' ) }}">{{ old( 'username' ) }}</textarea>
                            @error( 'message' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $announcement_create }}_image" class="col-sm-3 col-form-label">{{ __( 'announcement.image' ) }}</label>
                        <input type="file" id="{{ $announcement_create }}_image" name="image[]" multiple accept="image/*" />
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">{{ __( 'template.save_changes' ) }}</button>
                </form>
            </div>
        </div>
    </div>
</div>