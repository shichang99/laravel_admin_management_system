<?php
$multiSelect = 0;
?>

@if ( Session::has( 'success' ) )
<div class="alert alert-success" role="alert">
    <div class="d-flex align-items-center">
        <i icon-name="check-circle-2"></i>
        <strong>{{ Session::get( 'success' ) }}</strong>
    </div>
</div>
@endif

<div class="listing-header">
    <h3>{{ __( 'template.company_banks' ) }}</h3>
    <div>
        <a href="{{ route( 'admin.company_bank.create' ) }}" class="btn btn-sm btn-success">{{ __( 'template.create' ) }}</a>
    </div>
</div>
<br>

<?php
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
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'company_bank.number' ) ] ),
        'id' => 'number',
        'title' => __( 'company_bank.number' ),
    ],
    [
        'type' => 'default',
        'id' => 'details',
        'title' => __( 'company_bank.details' ),
    ],
    [
        'type' => 'default',
        'id' => 'type',
        'title' => __( 'company_bank.type' ),
    ],
    [
        'type' => 'default',
        'id' => 'is_primary',
        'title' => __( 'company_bank.is_primary' ),
    ],
    [
        'type' => 'default',
        'id' => 'status',
        'title' => __( 'datatables.status' ),
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
                <x-data-tables id="company_bank_table" enableFilter="true" enableFooter="false" columns="{{ json_encode( $columns ) }}" />
            </div>
        </div>
    </div>
</div>

<script>

window['columns'] = @json( $columns );
window['ids'] = [];

// Initialize global object of filter field
@foreach ( $columns as $column )
@if ( $column['type'] != 'default' )
window['{{$column['id']}}'] = '';
@endif
@endforeach

    var typeMapper = {
        '2': '{{ __( 'company_bank.usdt_trc20' ) }}',
        },
        dt_table,
        dt_table_name = '#company_bank_table',
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
                url: '{{ Helper::baseAdminUrl() }}/company-banks/all-company-banks',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                dataSrc: 'companyBanks',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            order: [[ 1, 'desc' ]],
            columns: [
                { data: null },
                { data: 'created_at' },
                { data: 'number' },
                { data: 'meta_data' },
                { data: 'type' },
                { data: 'is_primary' },
                { data: 'status' },
                { data: 'encrypted_id' },
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "number" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "details" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {

                        if ( row['type'] == 1 ) {

                            return data;
                        }

                        return '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "type" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return typeMapper[data];
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "is_primary" ) }}' ),
                    className: 'text-center',
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data == 1 ? '{{ __( 'datatables.yes' ) }}' : '{{ __( 'datatables.no' ) }}';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "status" ) }}' ),
                    className: 'text-center',
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data == 1 ? '{{ __( 'datatables.active' ) }}' : '{{ __( 'datatables.inactive' ) }}';
                    },
                },
                {
                    targets: parseInt( '{{ count( $columns ) - 1 }}' ),
                    orderable: false,
                    width: '10%',
                    className: 'text-center',
                    render: function( data, type, row, meta ) {

                        let edit = '<button class="btn btn-sm btn-warning dt-edit" data-id="' + data + '">{{ __( 'template.edit' ) }}</button>';

                        return edit;
                    },
                },
            ],
            select: {
                style: 'api',
            },
        },
        table_no = 0,
        timeout = null;

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

        window['createdDate'] = $( '#created_date' ).flatpickr( {
            mode: 'range',
            disableMobile: true,
            onClose: function( selected, dateStr, instance ) {
                window[$( instance.element ).data('id')] = $( instance.element ).val();
                dt_table.draw();
            }
        } );

        $( document ).on( 'click', '.dt-edit', function() {

            let id = $( this ).data( 'id' );
            
            window.location.href = '{{ route( 'admin.company_bank.modify' ) }}?id=' + id;
        } );
    } );
</script>

<script src="{{ asset( 'admin/js/dataTables.init.js' ) }}"></script>