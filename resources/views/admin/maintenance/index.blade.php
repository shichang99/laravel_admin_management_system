<?php
$maintenance_on = 'maintenance_on';
$maintenance_off = 'maintenance_off';
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
    <h3>{{ __( 'template.maintenances' ) }}</h3>
    <div>
        <a href="{{ route( 'admin.maintenance.create' ) }}" class="btn btn-sm btn-success">{{ __( 'template.create' ) }}</a>
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
        'type' => 'select',
        'options' => [
            [ 'title' => __( 'datatables.all_x', [ 'title' => __( 'maintenance.maintenances' ) ] ), 'key' => '', 'value' => '' ],
            [ 'title' => __( 'maintenance.daily_maintenance' ), 'key' => '1', 'value' => '1' ],
            [ 'title' => __( 'maintenance.temporary_maintenance' ), 'key' => '2', 'value' => '2' ],
            [ 'title' => __( 'maintenance.emergency_maintenance' ), 'key' => '3', 'value' => '3' ],
        ],
        'id' => 'type',
        'title' => __( 'maintenance.name' ),
        'preAmount' => true,
    ],
    [
        'type' => 'default',
        'id' => 'day',
        'title' => __( 'maintenance.days' ),
    ],
    [
        'type' => 'default',
        'id' => 'start_date',
        'title' => __( 'maintenance.start_date' ),
    ],
    [
        'type' => 'default',
        'id' => 'end_date',
        'title' => __( 'maintenance.end_date' ),
    ],
    [
        'type' => 'default',
        'id' => 'start_time',
        'title' => __( 'maintenance.start_time' ),
    ],
    [
        'type' => 'default',
        'id' => 'end_time',
        'title' => __( 'maintenance.end_time' ),
    ],
    [
        'type' => 'default',
        'id' => 'content',
        'title' => __( 'maintenance.content' ),
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
                <x-data-tables id="maintenance_table" enableFilter="true" enableFooter="false" columns="{{ json_encode( $columns ) }}" />
            </div>
        </div>
    </div>
</div>

<?php
$contents = [
    [
        'id' => '_id',
        'title' => __( 'setting.id' ),
        'placeholder' => __( 'setting.id' ),
        'type' => 'hidden',
    ],
];
?>

<x-modal title="{{ __( 'maintenance.on_maintenance' ) }}" subtitle="{{ __('maintenance.on_title',['title' => __('template.maintenances')])}}?" crud="{{ $maintenance_on }}" contents="{{ json_encode( $contents ) }}" />
<x-modal title="{{ __( 'maintenance.off_maintenance' ) }}"  subtitle="{{ __('maintenance.off_title',['title' => __('template.maintenances')])}}?"  crud="{{ $maintenance_off }}" contents="{{ json_encode( $contents ) }}" />

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

    var dt_table,
        dt_table_name = '#maintenance_table',
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
                url: '{{ Helper::baseAdminUrl() }}/maintenances/all-maintenances',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                dataSrc: 'maintenances',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            order: [[ 1, 'desc' ]],
            columns: [
                { data: null },
                { data: 'created_at' },
                { data: 'type' },
                { data: 'day' },
                { data: 'start_date' },
                { data: 'end_date' },
                { data: 'start_time' },
                { data: 'end_time' },
                { data: 'content' },
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
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return moment( data ).format( 'YYYY-MM-DD HH:mm:ss' );
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "type" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        if( data == 1 ) {
                            return '{{ __( 'maintenance.daily_maintenance' ) }}';
                        } else if( data == 2 ) {
                            return '{{ __( 'maintenance.temporary_maintenance' ) }}';
                        } else if( data == 3 ) {
                            return '{{ __( 'maintenance.emergency_maintenance' ) }}';
                        } else {
                            return '-';
                        }
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "start_date" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data ? moment( data ).format( 'YYYY-MM-DD' ) : '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "end_date" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data ? moment( data ).format( 'YYYY-MM-DD' ) : '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "start_time" ) }}' ),
                    render: function( data, type, row, meta ) {
                        return data ? data : '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "end_time" ) }}' ),
                    render: function( data, type, row, meta ) {
                        return data ? data : '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "content" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "status" ) }}' ),
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        return data == 1 ? '{{ __( 'maintenance.on' ) }}' : '{{ __( 'maintenance.off' ) }}';
                    },
                },
                {
                    targets: parseInt( '{{ count( $columns ) - 1 }}' ),
                    orderable: false,
                    width: '10%',
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        @can( 'edit maintenances' )
                        if(row.status==0){

                            let edit = '<button class="btn btn-sm btn-primary dt-edit" data-id="' + data + '">{{ __( 'template.edit' ) }}</button>';
                            onBtn = ' <button class="btn btn-sm btn-success dt-on" data-id="' + row['encrypted_id'] + '">{{ __( 'maintenance.on_maintenance' ) }}</button>';
                            return edit + onBtn;
                            
                        }else{
                            edit = '<button class="btn btn-sm btn-primary dt-edit" data-id="' + data + '">{{ __( 'template.edit' ) }}</button>';
                            offBtn = ' <button class="btn btn-sm btn-danger dt-off" data-id="' + row['encrypted_id'] + '">{{ __( 'maintenance.off_maintenance' ) }}</button>';
                            return  edit + offBtn;
                        }
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

        let mon = '#{{ $maintenance_on }}',
            moff = '#{{ $maintenance_off }}',
            maintenance_on_modal = new bootstrap.Modal( document.getElementById( 'maintenance_on_modal' ) ),
            maintenance_off_modal = new bootstrap.Modal( document.getElementById( 'maintenance_off_modal' ) ),
            toast = new bootstrap.Toast( document.getElementById( 'toast' ) );

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
            
            window.location.href = '{{ route( 'admin.maintenance.modify' ) }}?id=' + id;
        } );

        $( document ).on( 'click', '.dt-on', function() {

            let id = $( this ).data( 'id' );
            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/maintenances/one-maintenance',
                type: 'POST',
                data: { id, '_token': '{{ csrf_token() }}', },
                success: function( response ) {
                    
                    $( mon + '_id' ).val( id );
                    $( mon + '_status' ).val( response.status );

                    maintenance_on_modal.show();
                },
            } );
        } );

        $( document ).on( 'click', '.dt-off', function() {

            let id = $( this ).data( 'id' );

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/maintenances/one-maintenance',
                type: 'POST',
                data: { id, '_token': '{{ csrf_token() }}', },
                success: function( response ) {
                    
                    $( moff + '_id' ).val( id );
                    $( moff + '_status' ).val( response.status );

                    maintenance_off_modal.show();
                },
            } );
        } );

        $( mon + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/maintenances/update-maintenance-status',
                type: 'POST',
                data: {
                    'id': $( mon + '_id' ).val(),
                    'status': 1,
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'maintenance.maintenance_updated' ) }}' ); 
                    toast.show();
                    maintenance_on_modal.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            $( mon + '_' + key ).addClass( 'is-invalid' ).next().text( value );
                        } );
                    }
                }
            } );
        } );

        $( moff + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/maintenances/update-maintenance-status',
                type: 'POST',
                data: {
                    'id': $( moff + '_id' ).val(),
                    'status': 0,
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'maintenance.maintenance_updated' ) }}' );
                    toast.show();
                    maintenance_off_modal.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            $( moff + '_' + key ).addClass( 'is-invalid' ).next().text( value );
                        } );
                    }
                }
            } )
        } );

    } );
</script>

<script src="{{ asset( 'admin/js/dataTables.init.js' ) }}"></script>