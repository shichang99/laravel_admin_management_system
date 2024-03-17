<?php
$announcement_delete = 'announcement_delete';
$announcement_reactive = 'announcement_reactive';
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
    <h3>{{ __( 'template.announcements' ) }}</h3>
    <div>
        <a href="{{ route( 'admin.announcement.create' ) }}" class="btn btn-sm btn-success">{{ __( 'template.create' ) }}</a>
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
        'type' => 'default',
        'id' => 'image',
        'title' => __( 'announcement.image' ),
    ],
    [
        'type' => 'date',
        'placeholder' => __( 'datatables.search_x', [ 'title' => __( 'datatables.created_date' ) ] ),
        'id' => 'created_date',
        'title' => __( 'datatables.created_date' ),
    ],
    [
        'type' => 'input',
        'placeholder' =>  __( 'datatables.search_x', [ 'title' => __( 'announcement.title' ) ] ),
        'id' => 'title',
        'title' => __( 'announcement.title' ),
    ],
    [
        'type' => 'default',
        'id' => 'message',
        'title' => __( 'announcement.message' ),
    ],
    [
        'type' => 'select',
        'options' => $data['types'],
        'id' => 'type',
        'title' => __( 'announcement.type' ),
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
                <x-data-tables id="announcement_table" enableFilter="true" enableFooter="false" columns="{{ json_encode( $columns ) }}" />
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
    [
        'id' => '_display_name',
        'title' => __( 'announcement.title' ),
        'placeholder' => __( 'announcement.title' ),
        'type' => 'text',
        'mandatory' => true,
    ],
];
?>

<x-modal title="{{ __( 'announcement.' . $announcement_delete ) }}" subtitle="{{ __('template.delete_title',['title' => __('template.announcements')])}}?" crud="{{ $announcement_delete }}" contents="{{ json_encode( $contents ) }}" />
<x-modal title="{{ __( 'announcement.' . $announcement_reactive ) }}"  subtitle="{{ __('template.reactive_title',['title' => __('template.announcements')])}}?"  crud="{{ $announcement_reactive }}" contents="{{ json_encode( $contents ) }}" />

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
        dt_table_name = '#announcement_table',
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
                url: '{{ Helper::baseAdminUrl() }}/announcements/all-announcements',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                dataSrc: 'announcements',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            order: [[ 2, 'desc' ]],
            columns: [
                { data: null },
                { data: 'image' },
                { data: 'created_at' },
                { data: 'title' },
                { data: 'message' },
                { data: 'type' },
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "image" ) }}' ),
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "title" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {
                        if(data.length > 30)
                        {
                            data = data.substr(0,30) + "...";
                        }
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "message" ) }}' ),
                    orderable: false,
                    render: function( data, type, row, meta ) {

                        if(data.length > 30)
                        {
                            data = data.substr(0,30) + "...";
                        }
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "type" ) }}' ),
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        return data == 1 ? '{{ __( 'announcement.announcement' ) }}' : '{{ __( 'announcement.marquee' ) }}';
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
                        
                        @can( 'edit announcements' )
                        if(row.status==1){

                            let edit = '<button class="btn btn-sm btn-warning dt-edit" data-id="' + data + '">{{ __( 'template.edit' ) }}</button>';
                            deleteBtn = ' <button class="btn btn-sm btn-danger dt-delete" data-id="' + row['encrypted_id'] + '">{{ __( 'template.delete' ) }}</button>';
                            return edit + deleteBtn;
                            
                        }else{
                            reactiveBtn = ' <button class="btn btn-sm btn-success dt-reactive" data-id="' + row['encrypted_id'] + '">{{ __( 'template.reactive' ) }}</button>';
                            return reactiveBtn;
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

        let ar = '#{{ $announcement_reactive }}',
            ad = '#{{ $announcement_delete }}',
            announcement_reactive_modal = new bootstrap.Modal( document.getElementById( 'announcement_reactive_modal' ) ),
            announcement_delete_modal = new bootstrap.Modal( document.getElementById( 'announcement_delete_modal' ) ),
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

            window.location.href = '{{ route( 'admin.announcement.modify' ) }}?id=' + id;
        } );

        $( document ).on( 'click', '.dt-delete', function() {

            let id = $( this ).data( 'id' );
            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/announcements/one-announcement',
                type: 'POST',
                data: { id, '_token': '{{ csrf_token() }}', },
                success: function( response ) {
                    
                    $( ad + '_id' ).val( id );
                    $( ad + '_display_name' ).val( response.title );
                    $( ad + '_status' ).val( response.status );

                    announcement_delete_modal.show();
                },
            } );
        } );
        $( document ).on( 'click', '.dt-reactive', function() {

            let id = $( this ).data( 'id' );

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/announcements/one-announcement',
                type: 'POST',
                data: { id, '_token': '{{ csrf_token() }}', },
                success: function( response ) {
                    
                    $( ar + '_id' ).val( id );
                    $( ar + '_display_name' ).val( response.title );
                    $( ar + '_status' ).val( response.status );

                    announcement_reactive_modal.show();
                },
            } );
        } );
        $( ar + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/announcements/update-announcement-status',
                type: 'POST',
                data: {
                    'id': $( ar + '_id' ).val(),
                    'status': 1,
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'announcement.announcement_updated' ) }}' ); 
                    toast.show();
                    announcement_reactive_modal.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            $( ar + '_' + key ).addClass( 'is-invalid' ).next().text( value );
                        } );
                    }
                }
            } );
        } );

        $( ad + '_submit' ).click( function() {

            $.ajax( {
                url: '{{ Helper::baseAdminUrl() }}/announcements/update-announcement-status',
                type: 'POST',
                data: {
                    'id': $( ad + '_id' ).val(),
                    'status': 9,
                    '_token': '{{ csrf_token() }}',
                },
                success: function( response ) {
                    $( '#toast .toast-body' ).text( '{{ __( 'announcement.announcement_updated' ) }}' );
                    toast.show();
                    announcement_delete_modal.hide();
                    dt_table.draw();
                },
                error: function( error ) {
                    if ( error.status === 422 ) {
                        var errors = error.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            $( ad + '_' + key ).addClass( 'is-invalid' ).next().text( value );
                        } );
                    }
                }
            } )
        } );
    } );
</script>

<script src="{{ asset( 'admin/js/dataTables.init.js' ) }}"></script>