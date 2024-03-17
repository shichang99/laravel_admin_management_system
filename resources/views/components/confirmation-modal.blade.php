<div class="modal fade" id="{{ $crud }}_confirmation_modal" tabindex="-1" aria-labelledby="{{ $crud }}_confirmation_modal_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $crud }}_confirmation_modal_title">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>{{ $description }}</div>
                <div>
                    <input type="text" class="mt-2 form-control form-control-sm hidden confirmation_modal_remarks" placeholder="{{ __( 'template.enter_x', [ 'title' => __( 'datatables.remarks' ) ] ) }}"/>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __( 'template.cancel' ) }}</button>
                <button type="button" class="btn btn-success" id="{{ $crud }}_confirm">{{ __( 'template.confirm' ) }}</button>
            </div>
        </div>
    </div>
</div>