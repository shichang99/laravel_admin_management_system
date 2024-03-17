<?php
$member_create = 'member_create';
$member_edit = 'member_edit';

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

@if ( Session::has( 'error' ) )
<div class="alert alert-danger" role="alert">
    <div class="d-flex align-items-center">
        <i icon-name="alert-circle"></i>
        <strong class="me-2">{{ __( 'template.error' ) }}</strong>{{ Session::get( 'error' ) }}
    </div>        
</div>
@endif

<div class="listing-header">
    <h3>{{ __( 'template.members' ) }}</h3>
    <div>
        @if ( 1 == 2 )
        <button type="button" class="btn btn-success" data-bs-toggle="offcanvas" data-bs-target="#{{ $member_create }}_canvas">{{ __( 'template.create' ) }}</button>
        @endif
        <a href="{{ route( 'admin.member.register' ) }}" class="btn btn-sm btn-success">{{ __( 'template.create' ) }}</a>
        <button type="button" class="btn btn-sm btn-primary dt-export">{{ __( 'template.export' ) }}</button>
    </div>
</div>
<br>

<?php
array_unshift( $data['rankings'], [ 'title' => __( 'datatables.all_x', [ 'title' => __( 'member.ranking' ) ] ), 'value' => '' ] );

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
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'member.username' ) ] ),
        'id' => 'username',
        'title' => __( 'member.username' ),
    ],
    [
        'type' => 'input',
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'member.email' ) ] ),
        'id' => 'email',
        'title' => __( 'member.email' ),
    ],
    [
        'type' => 'input',
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'member.invitation_code' ) ] ),
        'id' => 'invitation_code',
        'title' => __( 'member.invitation_code' ),
    ],
    [
        'type' => 'select',
        'options' => $data['rankings'],
        'id' => 'ranking',
        'title' => __( 'member.ranking' ),
    ],
    [
        'type' => 'default',
        'id' => 'capital',
        'title' => __( 'member.capital' ),
    ],
    [
        'type' => 'input',
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'member.sponsor' ) ] ),
        'id' => 'sponsor',
        'title' => __( 'member.sponsor' ),
    ],
    [
        'type' => 'select',
        'options' => [
            [ 'title' => __( 'datatables.all_x', [ 'title' => __( 'datatables.status' ) ] ), 'key' => '', 'value' => '' ],
            [ 'title' => __( 'datatables.active' ), 'key' => '1', 'value' => '1' ],
            [ 'title' => __( 'datatables.inactive' ), 'key' => '9', 'value' => '9' ],
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
                <x-data-tables id="member_table" enableFilter="true" enableFooter="false" columns="{{ json_encode( $columns ) }}" />
            </div>
        </div>
    </div>
</div>

<?php
$contents = [
    [
        'id' => '_username',
        'title' => __( 'member.username' ),
        'placeholder' => __( 'member.username' ),
        'type' => 'text',
        'mandatory' => true,
    ],
    [
        'id' => '_email',
        'title' => __( 'member.email' ),
        'placeholder' => __( 'member.email' ),
        'type' => 'text',
        'mandatory' => true,
    ],
    [
        'id' => '_password',
        'title' => __( 'member.password' ),
        'placeholder' => __( 'member.password' ),
        'type' => 'password',
        'autocomplete' => 'new-password',
        'mandatory' => true,
    ],
];
?>

<x-off-canvas.off-canvas title="{{ __( 'member.' . $member_create ) }}" crud="{{ $member_create }}" contents="{{ json_encode( $contents ) }}" />

<?php
$contents[2]['title'] = __( 'member.leave_blank_password' );
$contents[2]['mandatory'] = false;

array_push( $contents, [
    'id' => '_id',
    'title' => __( 'member.id' ),
    'placeholder' => __( 'member.id' ),
    'type' => 'hidden',
] );
?>

<x-off-canvas.off-canvas title="{{ __( 'member.' . $member_edit ) }}" crud="{{ $member_edit }}" contents="{{ json_encode( $contents ) }}" />

<x-toast/>

<x-confirmation-modal crud="member_activate" title="{{ __( 'member.activate_member' ) }}" description="{{ __( 'member.activate_member_description' ) }}" />
<x-confirmation-modal crud="member_suspend" title="{{ __( 'member.suspend_member' ) }}" description="{{ __( 'member.suspend_member_description' ) }}" />

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
        dt_table_name = '#member_table',
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
                url: '{{ Helper::baseAdminUrl() }}/members/all-members',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                dataSrc: 'members',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            order: [[ 1, 'desc' ]],
            columns: [
                { data: null },
                { data: 'created_at' },
                { data: 'name' },
                { data: 'email' },
                { data: 'invitation_code' },
                { data: 'ranking.name' },
                { data: 'capital' },
                { data: 'sponsor.name' },
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "registered_date" ) }}' ),
                    render: function( data, type, row, meta ) {
                        return moment( data ).format( 'YYYY-MM-DD HH:mm:ss' );
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "sponsor" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        return data ? data : '-';
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
                        @canany( [ 'edit members' ] )

                        let edit = '<button class="btn btn-sm btn-primary dt-edit" data-id="' + data + '">{{ __( 'template.edit' ) }}</button>',
                            memberLogin = row.status == 1 ? ' <button class="btn btn-sm btn-warning dt-login" data-id="' + row['encrypted_id'] + '">{{ __( 'template.member_login' ) }}</button>' : '';

                        let status = row.status == 1 ? ' <button class="btn btn-sm btn-danger dt-status" data-id="' + data + '" data-status="9">{{ __( 'datatables.suspend' ) }}</button>' : ' <button class="btn btn-sm btn-success dt-status" data-id="' + data + '" data-status="1">{{ __( 'datatables.activate' ) }}</button>';

                        return edit + memberLogin + status;

                        @elsecanany

                        return '-';

                        @endcanany
                    },
                },
            ],
            select: {
                style: 'api',
            },
        },
        table_no = 0,
        timeout = null,
        exportPath = '{{ route( 'admin.member.export' ) }}';

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

        let uc = '#{{ $member_create }}',
            ue = '#{{ $member_edit }}',
            member_create_canvas = new bootstrap.Offcanvas( document.getElementById( 'member_create_canvas' ) ),
            member_edit_canvas = new bootstrap.Offcanvas( document.getElementById( 'member_edit_canvas' ) ),
            toast = new bootstrap.Toast( document.getElementById( 'toast' ) ),
            macm = new bootstrap.Modal( '#member_activate_confirmation_modal' ),
            mscm = new bootstrap.Modal( '#member_suspend_confirmation_modal' ),
            confirmation_target_id = 0,
            confirmation_target_value = 0;

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
            
            window.location.href = '{{ route( 'admin.member.modify' ) }}?id=' + id;
        } );

        $( document ).on( 'click', '.dt-status', function() {

            let id = $( this ).data( 'id' ),
                status = $( this ).data( 'status' );

            confirmation_target_id = id;
            confirmation_target_value = status;

            if ( status == '1' ) {
                macm.show();
            } else {
                mscm.show();
            }
        } );

        $( '#member_activate_confirm' ).click( function() {
            updateAdminStatus( macm );
        } );

        $( '#member_suspend_confirm' ).click( function() {
            updateAdminStatus( mscm );
        } );

        function updateAdminStatus( modal ) {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/members/update-member-status',
                type: 'POST',
                data: { 
                    id: confirmation_target_id,
                    status: confirmation_target_value,
                    '_token': '{{ csrf_token() }}'
                },
                success: function( response ) {
                    confirmation_target_id = 0;
                    confirmation_target_value = 0;
                    $( '#toast .toast-body' ).text( '{{ __( 'member.member_updated' ) }}' );
                    toast.show();
                    modal.hide();
                    dt_table.draw();
                },
            } );
        }

        $( uc + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/members/create-member',
                type: 'POST',
                data: {
                    'username': $( uc + '_username' ).val(),
                    'email': $( uc + '_email' ).val(),
                    'password': $( uc + '_password' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'member.member_created' ) }}' ); 
                    toast.show();
                    member_create_canvas.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            $( uc + '_' + key ).addClass( 'is-invalid' ).next().text( value );
                        } );
                    }
                }
            } );
        } );

        $( ue + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/members/update-member',
                type: 'POST',
                data: {
                    'id': $( ue + '_id' ).val(),
                    'username': $( ue + '_username' ).val(),
                    'email': $( ue + '_email' ).val(),
                    'password': $( ue + '_password' ).val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'member.member_updated' ) }}' );
                    toast.show();
                    member_edit_canvas.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            $( ue + '_' + key ).addClass( 'is-invalid' ).next().text( value );
                        } );
                    }
                }
            } )
        } );

        $( document ).on( 'click', '.dt-login', function() {

            window.open( '{{ route( 'admin.member.login' ) }}?id=' + $( this ).data( 'id' ), '_blank' );
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