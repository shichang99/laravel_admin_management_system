<?php
$multiSelect = 0;
?>

<div class="listing-header">
    <h3>{{ __( 'template.admin_logs' ) }}</h3>
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
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'administrator.username' ) ] ),
        'id' => 'username',
        'title' => __( 'administrator.username' ),
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
                <x-data-tables id="admin_log_table" enableFilter="true" enableFooter="true" columns="{{ json_encode( $columns ) }}" />
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

    var dt_table,
        dt_table_name = '#admin_log_table',
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
                url: '{{ Helper::baseAdminUrl() }}/administrators/admin-logs',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'username': '{{ request()->input( 'username' ) }}',
                },
                dataSrc: 'adminLogs',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            ordering: false,
            columns: [
                { data: null },
                { data: 'created_at' },
                { data: 'admin.name' },
                { data: 'description' },

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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "dt_action" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        str = data;
                        arr = str.split( " " );
                        for ( var i = 0; i < arr.length; i++ ) {
                            arr[i] = arr[i].charAt( 0 ).toUpperCase() + arr[i].slice( 1 );                      
                        }
                        output = arr.join( " " );
                        return output;
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

        @if ( request()->input( 'username' ) )
        $( '#username' ).val( '{{ request()->input( 'username' ) }}' );
        @endif
    } );
</script>

<script src="{{ asset( 'admin/js/dataTables.init.js' ) }}"></script>