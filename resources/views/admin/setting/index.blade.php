<?php
$setting_create = 'setting_create';
$setting_edit = 'setting_edit';

$multiSelect = 0;
?>

<div class="listing-header">
    <h3>{{ __( 'template.settings' ) }}</h3>
    <div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#{{ $setting_create }}_modal">{{ __( 'template.create' ) }}</button>
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
        'type' => 'default',
        'id' => 'display_name',
        'title' => __( 'setting.display_name' ),
    ],
    [
        'type' => 'input',
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'setting.key' ) ] ),
        'id' => 'key',
        'title' => __( 'setting.key' ),
    ],
    [
        'type' => 'default',
        'id' => 'value',
        'title' => __( 'setting.value' ),
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
                <x-data-tables id="setting_table" enableFilter="true" enableFooter="false" columns="{{ json_encode( $columns ) }}" />
            </div>
        </div>
    </div>
</div>

<?php
$contents = [
    [
        'id' => '_display_name',
        'title' => __( 'setting.display_name' ),
        'placeholder' => __( 'setting.display_name' ),
        'type' => 'text',
        'mandatory' => true,
    ],
    [
        'id' => '_key',
        'title' => __( 'setting.key' ),
        'placeholder' => __( 'setting.key' ),
        'type' => 'text',
        'mandatory' => true,
    ],
    [
        'id' => '_value',
        'title' => __( 'setting.value' ),
        'placeholder' => __( 'setting.value' ),
        'type' => 'text',
        'mandatory' => true,
    ],
];
?>

<x-modal title="{{ __( 'setting.' . $setting_create ) }}" crud="{{ $setting_create }}" contents="{{ json_encode( $contents ) }}" />

<?php
array_push( $contents, [
    'id' => '_id',
    'title' => __( 'setting.id' ),
    'placeholder' => __( 'setting.id' ),
    'type' => 'hidden',
] );
?>

<x-modal title="{{ __( 'setting.' . $setting_edit ) }}" crud="{{ $setting_edit }}" contents="{{ json_encode( $contents ) }}" />

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
        dt_table_name = '#setting_table',
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
                url: '{{ Helper::baseAdminUrl() }}/settings/all-settings',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                dataSrc: 'settings',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            order: [[ 1, 'desc' ]],
            columns: [
                { data: null },
                { data: 'created_at' },
                { data: 'name' },
                { data: 'key' },
                { data: 'value' },
                { data: 'status' },
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "created_date" ) }}' ),
                    render: function( data, type, row, meta ) {
                        return moment( data ).format( 'YYYY-MM-DD HH:mm:ss' );
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "display_name" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "key" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "value" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "status" ) }}' ),
                    className: 'text-center',
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
                        @can( 'edit settings' )

                        let edit = '<button class="btn btn-sm btn-warning dt-edit" data-id="' + data + '">{{ __( 'template.edit' ) }}</button>';

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

        let sc = '#{{ $setting_create }}',
            se = '#{{ $setting_edit }}',
            setting_create_modal = new bootstrap.Modal( document.getElementById( 'setting_create_modal' ) ),
            setting_edit_modal = new bootstrap.Modal( document.getElementById( 'setting_edit_modal' ) ),
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
            
            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/settings/one-setting',
                type: 'POST',
                data: { id, '_token': '{{ csrf_token() }}', },
                success: function( response ) {
                    
                    $( se + '_id' ).val( response.id );
                    $( se + '_display_name' ).val( response.name );
                    $( se + '_key' ).val( response.key );
                    $( se + '_value' ).val( response.value );

                    setting_edit_modal.show();
                },
            } );
        } );

        $( sc + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/settings/create-setting',
                type: 'POST',
                data: {
                    'display_name': $( sc + '_display_name' ).val(),
                    'key': $( sc + '_key' ).val(),
                    'value': $( sc + '_value' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'setting.setting_created' ) }}' ); 
                    toast.show();
                    setting_create_modal.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            $( sc + '_' + key ).addClass( 'is-invalid' ).next().text( value );
                        } );
                    }
                }
            } );
        } );

        $( se + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/settings/update-setting',
                type: 'POST',
                data: {
                    'id': $( se + '_id' ).val(),
                    'display_name': $( se + '_display_name' ).val(),
                    'key': $( se + '_key' ).val(),
                    'value': $( se + '_value' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'setting.setting_updated' ) }}' );
                    toast.show();
                    setting_edit_modal.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            $( se + '_' + key ).addClass( 'is-invalid' ).next().text( value );
                        } );
                    }
                }
            } )
        } );
    } );
</script>

<script src="{{ asset( 'admin/js/dataTables.init.js' ) }}"></script>