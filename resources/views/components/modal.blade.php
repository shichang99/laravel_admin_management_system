<div class="modal fade" id="{{ $crud }}_modal" tabindex="-1" aria-labelledby="{{ $crud }}_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $crud }}_modal_title">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach ( json_decode( html_entity_decode( $contents ) ) as $content )

                @if ( $content->type == 'hidden' )
                <input type="hidden" id="{{ $crud . $content->id }}" />
                    @continue
                @endif

                @if ( $content->type == 'select' )
                <x-off-canvas.floating-label-select class="form-select" id="{{ $crud . $content->id }}" title="{{ $content->title }}" options="{{ json_encode( $content->options ) }}" mandatory="{{ @$content->mandatory }}" />
                    @continue
                @endif

                @if ( $content->type == 'date' )
                <x-off-canvas.floating-label-date type="{{ $content->type }}" class="form-control" id="{{ $crud . $content->id }}" title="{{ $content->title }}" placeholder="{{ $content->placeholder }}" mandatory="{{ @$content->mandatory }}" />
                    @continue
                @endif

                @if ( $content->type == 'textarea' )
                <x-off-canvas.floating-label-textarea type="{{ $content->type }}" class="form-control" id="{{ $crud . $content->id }}" title="{{ $content->title }}" placeholder="{{ $content->placeholder }}" mandatory="{{ @$content->mandatory }}" />
                    @continue
                @endif

                @if ( $content->type == 'checkbox' )
                <x-off-canvas.checkbox type="{{ $content->type }}" id="{{ $crud . $content->id }}" title="{{ $content->title }}" />
                    @continue
                @endif

                @if ( $content->type == 'image' )
                    <div class="mb-3">
                        <h5 style="color: #495057">{{ $content->title }}</h5>
                        <div class="mb-3 mx-xl-6">
                            <div style="position: relative;">
                                <img src="{{ asset( 'admin/img/placeholder/fff.jpg' ) }}" id="{{ $crud . $content->id }}_preview" style="width: 100%;" />
                                <i class="hidden click-action" id="{{ $crud . $content->id }}_remove" style="position: absolute; top: -11.5px; right: -11.5px; stroke-width: 4; width: 24px; height: 24px" data-feather="x-circle" color="#aaa"></i>
                            </div>
                            <input type="file" id="{{ $crud . $content->id }}" class="hidden" accept="image/png, image/gif, image/jpeg">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    @continue
                @endif 

                <x-off-canvas.floating-label-input type="{{ $content->type }}" class="form-control" id="{{ $crud . $content->id }}" title="{{ $content->title }}" 
                    placeholder="{{ $content->placeholder }}" autocomplete="{{ @$content->autocomplete }}" mandatory="{{ @$content->mandatory }}" smalltext="{{ @$content->small_text }}" />

                @endforeach
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="{{ $crud }}_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
            </div>
        </div>
    </div>
</div>