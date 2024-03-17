<?php
$admin_create = 'admin_create';
$admin_edit = 'admin_edit';

$multiSelect = 0;
?>

<div class="listing-header">
    <h3>{{ __( 'template.administrators' ) }}</h3>
    <div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#{{ $admin_create }}_modal">{{ __( 'template.create' ) }}</button>
    </div>
</div>
<br>

<?php
array_unshift( $data['roles'],[ 'title' => __( 'datatables.all_x', [ 'title' => __( 'administrator.administrators' ) ] ), 'value' => '' ] );
$columns = [
    [
        'type' => 'default',
        'id' => 'dt_no',
        'title' => 'No.',
    ],
    [
        'type' => 'date',
        'placeholder' => __( 'datatables.search_x', [ 'title' => __( 'datatables.registered_date' ) ] ),
        'id' => 'registered_date',
        'title' => __( 'datatables.registered_date' ),
    ],
    [
        'type' => 'input',
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'administrator.username' ) ] ),
        'id' => 'username',
        'title' => __( 'administrator.username' ),
    ],
    [
        'type' => 'input',
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'administrator.email' ) ] ),
        'id' => 'email',
        'title' => __( 'administrator.email' ),
    ],
    [
        'type' => 'select',
        'options' => $data['roles'],
        'id' => 'roles',
        'title' => __( 'administrator.role' ),
    ],
    [
        'type' => 'select',
        'options' => [
            [ 'title' => __( 'datatables.all_x', [ 'title' => __( 'datatables.status' ) ] ), 'value' => '' ],
            [ 'title' => __( 'datatables.active' ), 'value' => '1' ],
            [ 'title' => __( 'datatables.suspended' ), 'value' => '9' ],
        ],
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
                <x-data-tables id="admin_table" enableFilter="true" enableFooter="false" columns="{{ json_encode( $columns ) }}" />
            </div>
        </div>
    </div>
</div>

<?php
array_shift( $data['roles'] ); // Remove the "all"
$contents = [
    [
        'id' => '_username',
        'title' => __( 'administrator.username' ),
        'placeholder' => __( 'administrator.username' ),
        'type' => 'text',
        'mandatory' => true,
    ],
    [
        'id' => '_email',
        'title' => __( 'administrator.email' ),
        'placeholder' => __( 'administrator.email' ),
        'type' => 'text',
        'mandatory' => true,
    ],
    [
        'id' => '_role',
        'title' => __( 'administrator.role' ),
        'placeholder' => __( 'administrator.role' ),
        'type' => 'select',
        'options' => $data['roles'],
        'mandatory' => true,
    ],
    [
        'id' => '_password',
        'title' => __( 'administrator.password' ),
        'placeholder' => __( 'administrator.password' ),
        'type' => 'password',
        'autocomplete' => 'new-password',
        'mandatory' => true,
    ],
];
?>

<x-modal title="{{ __( 'administrator.' . $admin_create ) }}" crud="{{ $admin_create }}" contents="{{ json_encode( $contents ) }}" />

<?php
$contents[3]['title'] = __( 'administrator.leave_blank' );
$contents[3]['mandatory'] = false;

array_push( $contents, [
    'id' => '_id',
    'title' => __( 'administrator.id' ),
    'placeholder' => __( 'administrator.id' ),
    'type' => 'hidden',
] );
?>

<x-modal title="{{ __( 'administrator.' . $admin_edit ) }}" crud="{{ $admin_edit }}" contents="{{ json_encode( $contents ) }}" />

<x-toast/>

<x-confirmation-modal crud="admin_activate" title="{{ __( 'administrator.activate_admin' ) }}" description="{{ __( 'administrator.activate_admin_description' ) }}" />
<x-confirmation-modal crud="admin_suspend" title="{{ __( 'administrator.suspend_admin' ) }}" description="{{ __( 'administrator.suspend_admin_description' ) }}" />

<script>

window['columns'] = @json( $columns );
window['ids'] = [];

// Initialize global object of filter field
@foreach ( $columns as $column )
@if ( $column['type'] != 'default' )
window['{{$column['id']}}'] = '';
@endif
@endforeach

    var rolesMapper = @json( $data['roles'] ),
        dt_table,
        dt_table_name = '#admin_table',
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
                url: '{{ Helper::baseAdminUrl() }}/administrators/all-admins',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                dataSrc: 'admins',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            order: [[ 1, 'desc' ]],
            columns: [
                { data: null },
                { data: 'created_at' },
                { data: 'name' },
                { data: 'email' },
                { data: 'role_name' },
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "registered_date" ) }}' ),
                    render: function( data, type, row, meta ) {
                        return moment( data ).format( 'YYYY-MM-DD HH:mm:ss' );
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "roles" ) }}' ),
                    render: function( data, type, row, meta ) {
                        return rolesMapper[rolesMapper.map( function( e ) { return e.key; } ).indexOf( data )].title;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "status" ) }}' ),
                    render: function( data, type, row, meta ) {
                        return data == 1 ? '{{ __( 'datatables.active' ) }}' : '{{ __( 'datatables.suspended' ) }}';
                    },
                },
                {
                    targets: parseInt( '{{ count( $columns ) - 1 }}' ),
                    orderable: false,
                    width: '10%',
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        @can( 'edit admins' )
                        let edit = '<button class="btn btn-sm btn-primary dt-edit" data-id="' + data + '">{{ __( 'template.edit' ) }}</button>',
                            status = row.status == 1 ? ' <button class="btn btn-sm btn-danger dt-status" data-id="' + data + '" data-status="9">{{ __( 'datatables.suspend' ) }}</button>' : ' <button class="btn btn-sm btn-success dt-status" data-id="' + data + '" data-status="1">{{ __( 'datatables.activate' ) }}</button>';

                        return edit + status;
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

        let ac = '#{{ $admin_create }}',
            ae = '#{{ $admin_edit }}',
            admin_create_modal = new bootstrap.Modal( document.getElementById( 'admin_create_modal' ) ),
            admin_edit_modal = new bootstrap.Modal( document.getElementById( 'admin_edit_modal' ) ),
            toast = new bootstrap.Toast( document.getElementById( 'toast' ) );

        window['registeredDate'] = $( '#registered_date' ).flatpickr( {
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
                url: '{{ Helper::baseAdminUrl() }}/administrators/one-admin',
                type: 'POST',
                data: { id, '_token': '{{ csrf_token() }}', },
                success: function( response ) {
                    
                    $( ae + '_id' ).val( response.id );
                    $( ae + '_username' ).val( response.name );
                    $( ae + '_email' ).val( response.email );
                    $( ae + '_role' ).val( response.role );

                    admin_edit_modal.show();
                },
            } );
        } );

        let aacm = new bootstrap.Modal( '#admin_activate_confirmation_modal' ),
            ascm = new bootstrap.Modal( '#admin_suspend_confirmation_modal' ),
            confirmation_target_id = 0,
            confirmation_target_value = 0;

        $( document ).on( 'click', '.dt-status', function() {

            let id = $( this ).data( 'id' ),
                status = $( this ).data( 'status' );

            confirmation_target_id = id;
            confirmation_target_value = status;

            if ( status == '1' ) {
                aacm.show();
            } else {
                ascm.show();
            }
        } );

        $( '#admin_activate_confirm' ).click( function() {
            updateAdminStatus( aacm );
        } );

        $( '#admin_suspend_confirm' ).click( function() {
            updateAdminStatus( ascm );
        } );

        function updateAdminStatus( modal ) {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/administrators/update-admin-status',
                type: 'POST',
                data: { 
                    id: confirmation_target_id,
                    status: confirmation_target_value,
                    '_token': '{{ csrf_token() }}'
                },
                success: function( response ) {
                    confirmation_target_id = 0;
                    confirmation_target_value = 0;
                    $( '#toast .toast-body' ).text( '{{ __( 'administrator.admin_updated' ) }}' );
                    toast.show();
                    modal.hide();
                    dt_table.draw();
                },
            } );
        }

        $( ac + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/administrators/create-admin',
                type: 'POST',
                data: {
                    'username': $( ac + '_username' ).val(),
                    'email': $( ac + '_email' ).val(),
                    'role': $( ac + '_role' ).val(),
                    'password': $( ac + '_password' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'administrator.admin_created' ) }}' ); 
                    toast.show();
                    admin_create_modal.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            $( ac + '_' + key ).addClass( 'is-invalid' ).next().text( value );
                        } );
                    }
                }
            } );
        } );

        $( ae + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/administrators/update-admin',
                type: 'POST',
                data: {
                    'id': $( ae + '_id' ).val(),
                    'username': $( ae + '_username' ).val(),
                    'email': $( ae + '_email' ).val(),
                    'role': $( ae + '_role' ).val(),
                    'password': $( ae + '_password' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'administrator.admin_updated' ) }}' );
                    toast.show();
                    admin_edit_modal.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            $( ae + '_' + key ).addClass( 'is-invalid' ).next().text( value );
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