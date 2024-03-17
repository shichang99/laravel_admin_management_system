<?php
$approve_topup = 'approve_topup';
$reject_topup = 'reject_topup';

$multiSelect = 1;
?>

<div class="listing-header">
    <h3>{{ __( 'template.topups' ) }}</h3>
    <div>
        <button type="button" class="btn btn-sm btn-primary dt-export">{{ __( 'template.export' ) }}</button>
    </div>
</div>
<br>

<?php
$wallets = Helper::wallets();
array_unshift( $wallets,[ 'title' => __( 'datatables.all_x', [ 'title' => __( 'wallet.wallet_type' ) ] ), 'value' => '' ] );

$columns = [
    [
        'type' => 'default',
        'id' => 'dt_no',
        'title' => 'No.',
    ],
    [
        'type' => 'default',
        'id' => 'attachment',
        'title' => __( 'member.attachment' ),
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
        'id' => 'payment_method',
        'title' => __( 'wallet.payment_method' ),
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
        'preAmount' => true,
    ],
    [
        'type' => 'default',
        'id' => 'amount',
        'title' => __( 'wallet.amount' ),
        'amount' => true,
    ],
];

if ( $multiSelect ) {
    array_unshift( $columns,  [
        'type' => 'default',
        'id' => 'dt_multiselect',
        'title' => '',
    ] );
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <x-data-tables id="topup_table" enableFilter="true" enableFooter="true" columns="{{ json_encode( $columns ) }}" />
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="approve_topup_modal" tabindex="-1" aria-labelledby="service_add_canvas_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="approve_topup_canvas_label">{{ __( 'wallet.approve_topup' ) }}</h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label" for="approve_topup_remark">{{ __( 'wallet.remark' ) }}</label>
                <textarea class="form-control" id="approve_topup_remark" style="height: 150px"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="approve_topup_id">
                <button type="submit" class="btn btn-success" id="approve_topup_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="offcanvas offcanvas-end offcanvas-right" tabindex="-1" id="approve_topup_canvas" aria-labelledby="service_add_canvas_label">
    <div class="offcanvas-header">
        <h2 id="approve_topup_canvas_label">{{ __( 'wallet.approve_topup' ) }}</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-3">
            <label class="form-label" for="approve_topup_remark">{{ __( 'wallet.remark' ) }}</label>
            <textarea class="form-control" id="approve_topup_remark" style="height: 150px"></textarea>
            <div class="invalid-feedback"></div>
        </div>
        <div class="offcanvas-button-group">
            <input type="hidden" name="id" id="approve_topup_id">
            <button type="submit" class="btn btn-success" id="approve_topup_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
        </div>
    </div>
</div> --}}

<!-- Modal -->
<div class="modal fade" id="reject_topup_modal" tabindex="-1" aria-labelledby="service_add_canvas_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="reject_topup_canvas_label">{{ __( 'wallet.reject_topup' ) }}</h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label" for="reject_topup_remark">{{ __( 'wallet.remark' ) }}</label>
                <textarea class="form-control" id="reject_topup_remark" style="height: 150px"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="reject_topup_id">
                <button type="submit" class="btn btn-success" id="reject_topup_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="offcanvas offcanvas-end offcanvas-right" tabindex="-1" id="reject_topup_canvas" aria-labelledby="service_add_canvas_label">
    <div class="offcanvas-header">
        <h2 id="reject_topup_canvas_label">{{ __( 'wallet.reject_topup' ) }}</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-3">
            <label class="form-label" for="reject_topup_remark">{{ __( 'wallet.remark' ) }}</label>
            <textarea class="form-control" id="reject_topup_remark" style="height: 150px"></textarea>
            <div class="invalid-feedback"></div>
        </div>
        <div class="offcanvas-button-group">
            <input type="hidden" name="id" id="reject_topup_id">
            <button type="submit" class="btn btn-success" id="reject_topup_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
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
        dt_table_name = '#topup_table',
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
                url: '{{ Helper::baseAdminUrl() }}/topups/all-member-topups',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                dataSrc: 'member_topups',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            order: [[ 1, 'desc' ]],
            columns: [
                { data: null },
                { data: 'attachment' },
                { data: 'created_at' },
                { data: 'user.name' },
                { data: 'type' },
                { data: 'payment_method' },
                { data: 'remark' },
                { data: 'status' },
                { data: 'amount' },
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "attachment" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {

                        if ( !data ) {
                            return '-';
                        }

                        let images = data.split( '|' ),
                            imageHtml = '';
                        
                        $.each( images, function( i, v ) {
                            imageHtml += `<img src="https://doc-image.s3-ap-southeast-1.amazonaws.com/` + v + `">`;
                        } );

                        return imageHtml;
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "payment_method" ) }}' ),
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        return data == 1 ? '{{ __( 'wallet.slip_topup' ) }}' : '{{ __( 'wallet.topup' ) }}';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "remark" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data;
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
            ],
            select: {
                style: 'api',
            },
        },
        table_no = 0,
        timeout = null,
        exportPath = '{{ route( 'admin.wallets.export_topup_list' ) }}';

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

    document.addEventListener( 'DOMContentLoaded', function() {

        let toast = new bootstrap.Toast( document.getElementById( 'toast' ) );

        window['createdDate'] = $( '#created_date' ).flatpickr( {
            mode: 'range',
            disableMobile: true,
            onClose: function( selected, dateStr, instance ) {
                window[$( instance.element ).data('id')] = $( instance.element ).val();
                dt_table.draw();
            }
        } );
    } );

    function multiselectApprove() {
        console.log( window['ids'] );

        let at = '#{{ $approve_topup }}',
            approveTopupCanvas = new bootstrap.Modal( document.getElementById( 'approve_topup_modal' ) ),
            toast = new bootstrap.Toast( document.getElementById( 'toast' ) );

        $( at + '_id' ).val( window['ids'] );
        approveTopupCanvas.show();

        $( at + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/topups/update-approve-topup',
                type: 'POST',
                data: {
                    'ids': $( at + '_id' ).val(),
                    'remark': $( at + '_remark' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'wallet.wallet_updated' ) }}' );
                    toast.show();
                    approveTopupCanvas.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, valwt ) {
                            $( at + '_' + key ).addClass( 'is-invalid' ).next().text( valwt );
                        } );
                    }
                }
            } )
        } );


    }

    function multiselectReject() {
        console.log( window['ids'] );

        let rt = '#{{ $reject_topup }}',
            rejectTopupCanvas = new bootstrap.Modal( document.getElementById( 'reject_topup_modal' ) ),
            toast = new bootstrap.Toast( document.getElementById( 'toast' ) );

        $( rt + '_id' ).val( window['ids'] );
        rejectTopupCanvas.show();

        $( rt + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/topups/update-reject-topup',
                type: 'POST',
                data: {
                    'ids': $( rt + '_id' ).val(),
                    'remark': $( rt + '_remark' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'wallet.wallet_updated' ) }}' );
                    toast.show();
                    rejectTopupCanvas.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, valwt ) {
                            $( rt + '_' + key ).addClass( 'is-invalid' ).next().text( valwt );
                        } );
                    }
                }
            } )
        } );

    }

</script>

<script src="{{ asset( 'admin/js/dataTables.init.js' ) }}"></script>