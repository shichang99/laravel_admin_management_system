<?php
$wallet_topup = 'wallet_topup';

$multiSelect = 0;
?>

<div class="listing-header">
    <h3>{{ __( 'template.wallets' ) }}</h3>
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
        'type' => 'input',
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'wallet.username' ) ] ),
        'id' => 'username',
        'title' => __( 'wallet.username' ),
    ],
    [
        'type' => 'select',
        'options' => $wallets,
        'id' => 'wallet_type',
        'title' => __( 'wallet.wallet_type' ),
        'preAmount' => true,
    ],
    [
        'type' => 'default',
        'id' => 'balance',
        'title' => __( 'wallet.balance' ),
        'amount' => true,
    ],
    [
        'type' => 'default',
        'id' => 'dt_action',
        'title' => __( 'datatables.action' ),
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
                <x-data-tables id="wallet_table" enableFilter="true" enableFooter="true" columns="{{ json_encode( $columns ) }}" />
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="wallet_topup_canvas" tabindex="-1" aria-labelledby="service_add_canvas_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="wallet_topup_canvas_label">{{ __( 'wallet.topup' ) }}</h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="wallet_topup_username" placeholder="{{ __( 'wallet.username' ) }}" readonly>
                    <div class="invalid-feedback"></div>
                    <label for="wallet_topup_username">{{ __( 'wallet.username' ) }}</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="wallet_topup_balance" placeholder="{{ __( 'wallet.balance' ) }}" readonly>
                    <div class="invalid-feedback"></div>
                    <label for="wallet_topup_balance">{{ __( 'wallet.balance' ) }}</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="wallet_topup_amount" placeholder="{{ __( 'wallet.amount' ) }}">
                    <div class="invalid-feedback"></div>
                    <label for="wallet_topup_amount">{{ __( 'wallet.amount' ) }}<span class="required">*</span></label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="wallet_topup_remark">{{ __( 'wallet.remark' ) }}</label>
                    <textarea class="form-control" id="wallet_topup_remark" style="height: 150px"></textarea>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="wallet_topup_id">
                <input type="hidden" name="id" id="wallet_topup_user_id">
                <button type="submit" class="btn btn-success" id="wallet_topup_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="offcanvas offcanvas-end offcanvas-right" tabindex="-1" id="wallet_topup_canvas" aria-labelledby="service_add_canvas_label">
    <div class="offcanvas-header">
        <h2 id="wallet_topup_canvas_label">{{ __( 'wallet.topup' ) }}</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="wallet_topup_username" placeholder="{{ __( 'wallet.username' ) }}" readonly>
            <div class="invalid-feedback"></div>
            <label for="wallet_topup_username">{{ __( 'wallet.username' ) }}</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="wallet_topup_balance" placeholder="{{ __( 'wallet.balance' ) }}" readonly>
            <div class="invalid-feedback"></div>
            <label for="wallet_topup_balance">{{ __( 'wallet.balance' ) }}</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="wallet_topup_amount" placeholder="{{ __( 'wallet.amount' ) }}">
            <div class="invalid-feedback"></div>
            <label for="wallet_topup_amount">{{ __( 'wallet.amount' ) }}<span class="required">*</span></label>
        </div>
        <div class="mb-3">
            <label class="form-label" for="wallet_topup_remark">{{ __( 'wallet.remark' ) }}</label>
            <textarea class="form-control" id="wallet_topup_remark" style="height: 150px"></textarea>
            <div class="invalid-feedback"></div>
        </div>
        <div class="offcanvas-button-group">
            <input type="hidden" name="id" id="wallet_topup_id">
            <input type="hidden" name="id" id="wallet_topup_user_id">
            <button type="submit" class="btn btn-success" id="wallet_topup_submit">{{ __( 'template.save_changes' ) }}</button>&nbsp;&nbsp;<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas" aria-label="Close" id="offcanvas_close">{{ __( 'template.cancel' ) }}</button>
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
        dt_table_name = '#wallet_table',
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
                url: '{{ Helper::baseAdminUrl() }}/wallets/all-member-wallets',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                dataSrc: 'member_wallets',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            // order: [[ 1, 'desc' ]],
            ordering: false,
            columns: [
                { data: null },
                { data: 'user.name' },
                { data: 'type' },
                { data: 'balance' },
                { data: 'id' },
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "balance" ) }}' ),
                    orderable: false,
                    className: 'text-end',
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ count( $columns ) - 1 }}' ),
                    orderable: false,
                    width: '10%',
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        @can( 'edit wallets' )

                        let edit = '<button class="btn btn-sm btn-success dt-edit" data-id="' + data + '">{{ __( 'wallet.topup' ) }}</button>';

                        return edit;
                        @else
                        return '-';
                        @endcan
                    },
                },
            ],
            select: {
                style: 'api',
            },
        },
        table_no = 0,
        timeout = null,
        exportPath = '{{ route( 'admin.wallets.export_wallet_list' ) }}';

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
                return '<input class="dt-multiselect" type="checkbox" style="width: 100%" data-id="' + data + '" />';
            },
        } );
    }

    document.addEventListener( 'DOMContentLoaded', function() {

        let wt = '#{{ $wallet_topup }}',
            walletTopupCanvas = new bootstrap.Modal( document.getElementById( 'wallet_topup_canvas' ) ),
            toast = new bootstrap.Toast( document.getElementById( 'toast' ) );

        $( document ).on( 'click', '.dt-edit', function() {

            let id = $( this ).data( 'id' );
            
            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/wallets/one-member-wallet',
                type: 'POST',
                data: { id, '_token': '{{ csrf_token() }}', },
                success: function( response ) {
                    
                    $( wt + '_id' ).val( response.id );
                    $( wt + '_username' ).val( response.user.name );
                    $( wt + '_balance' ).val( response.balance );

                    walletTopupCanvas.show();
                },
            } );
        } );

        $( wt + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/wallets/update-member-wallet',
                type: 'POST',
                data: {
                    'id': $( wt + '_id' ).val(),
                    'amount': $( wt + '_amount' ).val(),
                    'remark': $( wt + '_remark' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'wallet.wallet_updated' ) }}' );
                    toast.show();
                    walletTopupCanvas.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, valwt ) {
                            $( wt + '_' + key ).addClass( 'is-invalid' ).next().text( valwt );
                        } );
                    }
                }
            } )
        } );
    } );

    function multiselectApprove() {
        console.log( window['ids'] );
    }

    function multiselectReject() {
        console.log( window['ids'] );
    }
</script>

<script src="{{ asset( 'admin/js/dataTables.init.js' ) }}"></script>