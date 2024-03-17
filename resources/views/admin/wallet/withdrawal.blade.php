<?php
$approve_withdrawal = 'approve_withdrawal';
$approve_api_withdrawal = 'approve_api_withdrawal';
$reject_withdrawal = 'reject_withdrawal';

$multiSelect = 1;
?>

<div class="listing-header">
    <h3>{{ __( 'template.withdrawals' ) }}</h3>
    <div>
        <button type="button" class="btn btn-sm btn-primary dt-export">{{ __( 'template.export' ) }}</button>
    </div>
</div>
<br>

<?php
$wallets = Helper::wallets();
array_unshift( $wallets, [ 'title' => __( 'datatables.all_x', [ 'title' => __( 'wallet.wallet_type' ) ] ), 'value' => '' ] );

$columns = [
    [
        'type' => 'default',
        'id' => 'dt_no',
        'title' => 'No.',
    ],
    [
        'type' => 'date',
        'placeholder' => __( 'datatables.search_x', [ 'title' => __( 'datatables.created_date' ) ] ),
        'id' => 'created_date',
        'title' => __( 'datatables.created_date' ),
    ],
    [
        'type' => 'input',
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'member.username' ) ] ),
        'id' => 'username',
        'title' => __( 'member.username' ),
    ],
    [
        'type' => 'select',
        'options' => $wallets,
        'id' => 'wallet_type',
        'title' => __( 'wallet.wallet_type' ),
    ],
    [
        'type' => 'default',
        'id' => 'withdraw_method',
        'title' => __( 'wallet.withdraw_method' ),
    ],
    [
        'type' => 'default',
        'id' => 'withdraw_detail',
        'title' => __( 'wallet.withdraw_detail' ),
        'preAmount' => true,
    ],
    [
        'type' => 'default',
        'id' => 'amount',
        'title' => __( 'wallet.amount' ),
        'amount' => true,
    ],
    [
        'type' => 'default',
        'id' => 'processing_fee',
        'title' => __( 'wallet.processing_fee' ),
        'amount' => true,
    ],
    [
        'type' => 'default',
        'id' => 'actual_amount',
        'title' => __( 'wallet.actual_amount' ),
        'amount' => true,
    ],
    [
        'type' => 'default',
        'id' => 'remark',
        'title' => __( 'wallet.remark' ),
    ],
    [
        'type' => 'select',
        'options' => [
            [ 'title' => __( 'datatables.all_x', [ 'title' => __( 'datatables.status' ) ] ), 'key' => '', 'value' => '' ],
            [ 'title' => __( 'member.pending' ), 'key' => '0', 'value' => '0' ],
            [ 'title' => __( 'member.approved' ), 'key' => '1', 'value' => '1' ],
            [ 'title' => __( 'member.rejected' ), 'key' => '9', 'value' => '9' ],
        ],
        'id' => 'status',
        'title' => __( 'datatables.status' ),
    ],
];

if ( $multiSelect ) {
    array_unshift( $columns,  [
        'type' => 'default',
        'id' => 'dt_multiselect',
        'title' => '',
        'multi_select' => 'yes',
    ] );
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <x-data-tables id="withdrawal_table" enableFilter="true" enableFooter="true" columns="{{ json_encode( $columns ) }}" />
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="approve_withdrawal_modal" tabindex="-1" aria-labelledby="service_add_canvas_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="approve_withdrawal_canvas_label">{{ __( 'wallet.approve_withdrawal' ) }}</h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label" for="approve_withdrawal_remark">{{ __( 'wallet.remark' ) }}</label>
                <textarea class="form-control" id="approve_withdrawal_remark" style="height: 150px"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="approve_withdrawal_id">
                <button type="submit" class="btn btn-success" id="approve_withdrawal_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="offcanvas offcanvas-end offcanvas-right" tabindex="-1" id="approve_withdrawal_canvas" aria-labelledby="service_add_canvas_label">
    <div class="offcanvas-header">
        <h2 id="approve_withdrawal_canvas_label">{{ __( 'wallet.approve_withdrawal' ) }}</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-3">
            <label class="form-label" for="approve_withdrawal_remark">{{ __( 'wallet.remark' ) }}</label>
            <textarea class="form-control" id="approve_withdrawal_remark" style="height: 150px"></textarea>
            <div class="invalid-feedback"></div>
        </div>
        <div class="offcanvas-button-group">
            <input type="hidden" name="id" id="approve_withdrawal_id">
            <button type="submit" class="btn btn-success" id="approve_withdrawal_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
        </div>
    </div>
</div> --}}

<!-- Modal -->
<div class="modal fade" id="approve_api_withdrawal_modal" tabindex="-1" aria-labelledby="service_add_canvas_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="approve_api_withdrawal_canvas_label">{{ __( 'wallet.approve_api_withdrawal' ) }}</h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label" for="approve_api_withdrawal_remark">{{ __( 'wallet.remark' ) }}</label>
                <textarea class="form-control" id="approve_api_withdrawal_remark" style="height: 150px"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="approve_api_withdrawal_id">
                <button type="submit" class="btn btn-success" id="approve_api_withdrawal_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="offcanvas offcanvas-end offcanvas-right" tabindex="-1" id="approve_api_withdrawal_canvas" aria-labelledby="approve_api_withdrawal_canvas_label">
    <div class="offcanvas-header">
        <h2 id="approve_api_withdrawal_canvas_label">{{ __( 'wallet.approve_api_withdrawal' ) }}</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-3">
            <label class="form-label" for="approve_api_withdrawal_remark">{{ __( 'wallet.remark' ) }}</label>
            <textarea class="form-control" id="approve_api_withdrawal_remark" style="height: 150px"></textarea>
            <div class="invalid-feedback"></div>
        </div>
        <div class="offcanvas-button-group">
            <input type="hidden" name="id" id="approve_api_withdrawal_id">
            <button type="submit" class="btn btn-success" id="approve_api_withdrawal_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
        </div>
    </div>
</div> --}}

<!-- Modal -->
<div class="modal fade" id="reject_withdrawal_modal" tabindex="-1" aria-labelledby="service_add_canvas_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="reject_withdrawal_canvas_label">{{ __( 'wallet.reject_withdrawal' ) }}</h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label" for="reject_withdrawal_remark">{{ __( 'wallet.remark' ) }}</label>
                <textarea class="form-control" id="reject_withdrawal_remark" style="height: 150px"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="reject_withdrawal_id">
                <button type="submit" class="btn btn-success" id="reject_withdrawal_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="offcanvas offcanvas-end offcanvas-right" tabindex="-1" id="reject_withdrawal_canvas" aria-labelledby="service_add_canvas_label">
    <div class="offcanvas-header">
        <h2 id="reject_withdrawal_canvas_label">{{ __( 'wallet.reject_withdrawal' ) }}</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-3">
            <label class="form-label" for="reject_withdrawal_remark">{{ __( 'wallet.remark' ) }}</label>
            <textarea class="form-control" id="reject_withdrawal_remark" style="height: 150px"></textarea>
            <div class="invalid-feedback"></div>
        </div>
        <div class="offcanvas-button-group">
            <input type="hidden" name="id" id="reject_withdrawal_id">
            <button type="submit" class="btn btn-success" id="reject_withdrawal_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
        </div>
    </div>
</div> --}}

<x-toast/>

<script>

window['columns'] = @json( $columns );
window['ids'] = [];

// Initialize global object of filter field
@foreach ( $columns as $column )
@if ( $column['type'] != 'default' )
window['{{$column['id']}}'] = '';
@endif
@endforeach

    var walletTypes = @json( $wallets ),
        dt_table,
        dt_table_name = '#withdrawal_table',
        dt_table_config = {
            language: {
                'lengthMenu': '{{ __( "datatables.lengthMenu" ) }}',
                'zeroRecords': '{{ __( "datatables.zeroRecords" ) }}',
                'info': '{{ __( "datatables.info" ) }}',
                'infoEmpty': '{{ __( "datatables.infoEmpty" ) }}',
                'infoFiltered': '{{ __( "datatables.infoFiltered" ) }}',
                'paginate': {
                    'previous': '{{ __( "datatables.previous" ) }}',
                    'next': '{{ __( "datatables.next" ) }}',
                },
                'select': {
                    'rows': {
                        0: "",
                        _: "{{ __( "datatables.rows" ) }}",
                    }
                },
            },
            ajax: {
                url: '{{ Helper::baseAdminUrl() }}/withdrawals/all-member-withdrawals',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                dataSrc: 'withdrawals',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            order: [[ 2, 'desc' ]],
            columns: [
                { data: null },
                { data: 'created_at' },
                { data: 'user.name' },
                { data: 'wallet_type' },
                { data: 'withdraw_method' },
                { data: 'member_bank_detail' },
                { data: 'original_amount' },
                { data: 'original_process_fee' },
                { data: 'original_actual_amount' },
                { data: 'remark' },
                { data: 'status' },
            ],
            columnDefs: [
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "dt_no" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return table_no += 1;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "created_date" ) }}' ),
                    render: function( data, type, row, meta ) {
                        return moment( data ).format( 'YYYY-MM-DD HH:mm:ss' );
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "username" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "wallet_type" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return walletTypes[walletTypes.map( function( e ) { return e.key; } ).indexOf( data )].title;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "withdraw_method" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return 'TRC20';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "withdraw_detail" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "remark" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data ? data : '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "status" ) }}' ),
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        if( data == 0 ) {
                            return '{{ __( 'member.pending' ) }}';
                        } else if( data == 1 ) {
                            return '{{ __( 'member.approved' ) }}';
                        } else if( data == 9 ) {
                            return '{{ __( 'member.rejected' ) }}';
                        } else {
                            return '{{ __( 'member.cancelled' ) }}';
                        }
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "amount" ) }}' ),
                    orderable: false,
                    className: 'text-end',
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "processing_fee" ) }}' ),
                    orderable: false,
                    className: 'text-end',
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "actual_amount" ) }}' ),
                    orderable: false,
                    className: 'text-end',
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
            ],
            select: {
                info: false,
                style: 'api',
            },
        },
        table_no = 0,
        timeout = null,
        exportPath = '{{ route( 'admin.wallets.export_withdrawal_list' ) }}';

    if ( parseInt( '{{ $multiSelect }}' ) == 1 ) {

        dt_table_config.select.style = 'multi';
        dt_table_config.select['selector'] = 'td:first-child';

        dt_table_config.order[0] = [ 2, 'desc' ],
        dt_table_config.columns.unshift( {
            data: 'id'
        } );
        dt_table_config.columnDefs.unshift( {
            targets: 0,
            orderable: false,
            render: function( data, type, row, meta ) {

                if ( row['status'] == 0 ) {
                    return '<input class="dt-multiselect" type="checkbox" style="width: 100%" data-id="' + data + '" />';
                } else {
                    return '';
                }
            },
        } );
    }

    let aw = '#{{ $approve_withdrawal }}',
        aaw = '#{{ $approve_api_withdrawal }}',
        rw = '#{{ $reject_withdrawal }}',
        toast = null,
        approveWithdrawalCanvas = null,
        approveApiWithdrawalCanvas = null,
        rejectWithdrawalCanvas = null;

    document.addEventListener( 'DOMContentLoaded', function() {

        toast = new bootstrap.Toast( document.getElementById( 'toast' ) );

        window['createdDate'] = $( '#created_date' ).flatpickr( {
            mode: 'range',
            disableMobile: true,
            onClose: function( selected, dateStr, instance ) {
                window[$( instance.element ).data('id')] = $( instance.element ).val();
                dt_table.draw();
            }
        } );

        // $( '#multiselect_approve' ).after( '&nbsp;<button id="multiselect_api_approve" type="button" class="btn btn-secondary btn-icon-text"><i class="btn-icon-prepend" icon-name="check-circle-2"></i>{{ __( 'datatables.api_approve' ) }}</button>' );

        approveWithdrawalCanvas = new bootstrap.Modal( document.getElementById( 'approve_withdrawal_modal' ) );
        approveApiWithdrawalCanvas = new bootstrap.Modal( document.getElementById( 'approve_api_withdrawal_modal' ) );
        rejectWithdrawalCanvas = new bootstrap.Modal( document.getElementById( 'reject_withdrawal_modal' ) );

        $( aw + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/withdrawals/update-approve-withdrawal',
                type: 'POST',
                data: {
                    'ids': window['ids'].join(','),
                    'remark': $( aw + '_remark' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'wallet.withdrawal_updated' ) }}' );
                    toast.show();
                    approveWithdrawalCanvas.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, valwt ) {
                            $( aw + '_' + key ).addClass( 'is-invalid' ).next().text( valwt );
                        } );
                    }
                }
            } )
        } );

        $( aaw + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/withdrawals/update-api-approve-withdrawal',
                type: 'POST',
                    data: {
                        'ids': window['ids'].join(','),
                        'remark': $( aaw + '_remark' ).val(),
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function( response ) {
                        $( '#toast .toast-body' ).text( '{{ __( 'wallet.withdrawal_updated' ) }}' );
                        toast.show();
                        approveApiWithdrawalCanvas.hide();
                        dt_table.draw();
                    },
                    error: function( error ) {
                        if ( error.status === 422 ) {
                            var errors = error.responseJSON.errors;
                            $.each( errors, function( key, valwt ) {
                                $( aaw + '_' + key ).addClass( 'is-invalid' ).next().text( valwt );
                            } );
                        }
                    }
            } );
        } );

        $( rw + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/withdrawals/update-reject-withdrawal',
                type: 'POST',
                data: {
                    'ids': window['ids'].join(','),
                    'remark': $( rw + '_remark' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'wallet.withdrawal_updated' ) }}' );
                    toast.show();
                    rejectWithdrawalCanvas.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, valwt ) {
                            $( rw + '_' + key ).addClass( 'is-invalid' ).next().text( valwt );
                        } );
                    }
                }
            } )
        } );
    } );

    function multiselectApiApprove() {
        approveApiWithdrawalCanvas.show();
    }

    function multiselectApprove() {
        approveWithdrawalCanvas.show();
    }

    function multiselectReject() {
        rejectWithdrawalCanvas.show();
    }

</script>

<script src="{{ asset( 'admin/js/dataTables.init.js?v=1' ) }}"></script>