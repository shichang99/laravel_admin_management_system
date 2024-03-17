<?php
$multiSelect = 0;
?>

<div class="listing-header">
    <h3>{{ __( 'template.groups' ) }}</h3>
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
        'type' => 'default',
        'id' => 'account_type',
        'title' => __( 'member.account_type' ),
    ],
    [
        'type' => 'default',
        'id' => 'package',
        'title' => __( 'member.package' ),
    ],
    [
        'type' => 'default',
        'id' => 'ranking',
        'title' => __( 'member.ranking' ),
    ],
    [
        'type' => 'default',
        'id' => 'capital',
        'title' => __( 'member.capital' ),
    ],
    [
        'type' => 'default',
        'id' => 'sponsor',
        'title' => __( 'member.sponsor' ),
    ],
    [
        'type' => 'default',
        'id' => 'sponsor_capital',
        'title' => __( 'member.sponsor_capital' ),
    ],
    [
        'type' => 'default',
        'id' => 'sponsor_ranking',
        'title' => __( 'member.sponsor_ranking' ),
    ],
    [
        'type' => 'default',
        'id' => 'level',
        'title' => __( 'member.level' ),
    ],
    [
        'type' => 'default',
        'id' => 'level',
        'title' => __( 'member.total_direct_sponsor' ),
    ],
    [
        'type' => 'default',
        'id' => 'total_group',
        'title' => __( 'member.total_group' ),
    ],
    [
        'type' => 'default',
        'id' => 'status',
        'title' => __( 'datatables.status' ),
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
                url: '{{ Helper::baseAdminUrl() }}/members/groups',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'username': '{{ request()->input( 'username' ) }}',
                },
                dataSrc: 'members',
            },
            lengthMenu: [[10, 50, 9999999],[10, 50, '{{ __( 'datatables.all' ) }}']],
            ordering: false,
            columns: [
                { data: null },
                { data: 'created_at' },
                { data: 'name' },
                { data: 'is_free_acc' },
                { data: 'package' },
                { data: 'ranking' },
                { data: 'capital' },
                { data: 'sponsor' },
                { data: 'sponsor' },
                { data: 'sponsor' },
                { data: 'sponsor_structure' },
                { data: 'total_direct_sponsor' },
                { data: 'total_group' },
                { data: 'status' },
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
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "account_type" ) }}' ),
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        return data == 0 ? '{{ __( 'member.real' ) }}' : '{{ __( 'member.free' ) }}';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "package" ) }}' ),
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        return data ? data.name : '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "ranking" ) }}' ),
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        return data ? data.name : '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "capital" ) }}' ),
                    className: 'text-end',
                    render: function( data, type, row, meta ) {
                        return data;
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "sponsor" ) }}' ),
                    render: function( data, type, row, meta ) {
                        return data ? '<a href="{{ route( 'admin.member.group' ) }}?username=' + data.name + '">' + data.name + '</a>' : '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "sponsor_capital" ) }}' ),
                    className: 'text-end',
                    render: function( data, type, row, meta ) {
                        return data ? data.capital : '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "sponsor_ranking" ) }}' ),
                    className: 'text-center',
                    render: function( data, type, row, meta ) {
                        return data?.ranking?.name ? data.ranking.name : '-';
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "level" ) }}' ),
                    render: function( data, type, row, meta ) {
                        let a = data + '|' + row['id'];
                        return a.split( '|' ).reverse().indexOf( meta.settings.json.searchUser );
                    },
                },
                {
                    targets: parseInt( '{{ Helper::columnIndex( $columns, "status" ) }}' ),
                    render: function( data, type, row, meta ) {
                        return data == 1 ? '{{ __( 'datatables.active' ) }}' : '{{ __( 'datatables.inactive' ) }}';
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
        @if ( request()->input( 'username' ) )
        $( '#username' ).val( '{{ request()->input( 'username' ) }}' );
        @endif
    } );
</script>

<script src="{{ asset( 'admin/js/dataTables.init.js' ) }}"></script>