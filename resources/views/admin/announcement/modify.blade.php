<?php
$announcement_edit = 'announcement_edit';

// var_dump($data['announcements']);
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

<h3>{{ __( 'announcement.announcement_edit' ) }}</h3>
<br>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="card-title">{{ __( 'announcement.announcement_detail' ) }}</h6>
                <form action="{{ route('admin.announcement.update') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="encrypted_id" value="{{ request()->get( 'id' ) }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="{{ $announcement_edit }}_language" class="col-sm-3 col-form-label">{{ __( 'announcement.language' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'language' ) is-invalid @enderror" id="{{ $announcement_edit }}_language" name="language">
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
                        <label for="{{ $announcement_edit }}_type" class="col-sm-3 col-form-label">{{ __( 'announcement.type' ) }}</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error( 'type' ) is-invalid @enderror" id="{{ $announcement_edit }}_type" name="type">
                                @foreach ( $data['types'] as $type )
                                <?php
                                $selectedID = 0;
                                if ( old( 'type' ) ) {
                                    $selectedID = old( 'type' );
                                } else {
                                    $selectedID = $data['announcements']['type'];
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
                        <label for="{{ $announcement_edit }}_title" class="col-sm-3 col-form-label">{{ __( 'announcement.title' ) }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm @error( 'title' ) is-invalid @enderror" id="{{ $announcement_edit }}_title" name="title" placeholder="{{ __( 'announcement.title' ) }}" value="{{ old( 'title' ) ? old( 'title' ) : $data['announcements']['title'] }}">
                            @error( 'title' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="{{ $announcement_edit }}_message" class="col-sm-3 col-form-label">{{ __( 'announcement.message' ) }}</label>
                        <div class="col-sm-9">
                            <textarea rows="20" class="form-control form-control-sm @error( 'message' ) is-invalid @enderror" id="{{ $announcement_edit }}_message" name="message" placeholder="{{ __( 'announcement.message' ) }}">{{old( 'message' ) ? old( 'message' ) : $data['announcements']['message'] }}</textarea>
                            @error( 'message' )
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="{{ $announcement_edit }}_image" class="col-sm-3 col-form-label">{{ __( 'announcement.image' ) }}</label>
                        <div class="col-md-7 pr-1">
                            <div class="form-group ">
                                
                                @if($data['announcements']['image']!='' )
                                    @php $images = explode('|', $data['announcements']['image']); @endphp
                                    @foreach($images as $row)
                                    <div class="upload-img">
                                        <img class="images-preview img-responsive center-block" id="image-upload" src="{{Storage::disk('s3')->url($row)}}">
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <input type="file" id="{{ $announcement_edit }}_image" name="image[]" multiple accept="image/*" />
                    </div>
                    
                    <button type="submit" class="btn btn-sm btn-success">{{ __( 'template.save_changes' ) }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    document.addEventListener( 'DOMContentLoaded', function() {

        let ae = '#{{ $announcement_edit }}';

        $( ae + '_language' ).on( 'change', function() {

            let locale = $( this ).val(),
                id = '{{ request()->input( 'id' ) }}';

            $.ajax( {
                url: '{{ route( 'admin.announcement.lang' ) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    locale,
                    id,
                },
                success: function( response ) {
                    
                    $( ae + '_title' ).val( response.title );
                    $( ae + '_message' ).val( response.message );
                },
            } )

        } );
    } );
    
</script>