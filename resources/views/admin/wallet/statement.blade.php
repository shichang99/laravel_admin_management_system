<?php
$multiSelect = 0;
?>

<div class="listing-header">
    <h3>{{ __( 'template.statements' ) }}</h3>
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
        'id' => 'remark',
        'title' => __( 'wallet.remark' ),
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
                <x-data-tables id="statement_table" enableFilter="true" enableFooter="true" columns="{{ json_encode( $columns ) }}" walletStatement="true" />
            </div>
        </div>
    </div>
</div>

<x-toast/>

<?php

$newColumns = $columns;
array_push( $newColumns, [
        'type' => 'input',
        'id' => 'trxtype',
        'title' => __( 'wallet.trxtype' ),
] );
?>

<script>

window['columns'] = @json( $newColumns );
window['ids'] = [];

// Initialize global object of filter field
@foreach ( $newColumns as $column )
@if ( $column['type'] != 'default' )
window['{{$column['id']}}'] = '';
@endif
@endforeach

    var walletTypes = @json( $wallets ),
        dt_table,
        dt_table_name = '#statement_table',
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
                url: '{{ Helper::baseAdminUrl() }}/wallets/all-member-statements',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                dataSrc: 'transactions',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            order: [[ 1, 'desc' ]],
            columns: [
                { data: null },
                { data: 'created_at' },
                { data: 'user.name' },
                { data: 'type' },
                { data: 'converted_remark' },
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "remark" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data;
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
        exportPath = '{{ route( 'admin.wallets.export_statement_list' ) }}';

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
</script>

<script src="{{ asset( 'admin/js/dataTables.init.js' ) }}"></script>