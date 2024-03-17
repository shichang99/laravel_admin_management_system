<?php $columns = json_decode( html_entity_decode( $columns ) ); ?>
@if ( $enableFilter == 'true' )
<div class="listing-filter">
@foreach ( $columns as $key => $column )
@if ( $column->type != 'default' )
{!! renderFilter( $column->type, $column ) !!}
@endif
@endforeach
</div>

@if ( $walletStatement == 'true' )
<div class="mb-4">
@foreach ( Helper::trxtype() as $tx )
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="trxtype_{{ $tx['value'] }}" value="{{ $tx['value'] }}" data-id="trxtype">
        <label class="form-check-label" for="trxtype_{{ $tx['value'] }}">{{ $tx['title'] }}</label>
    </div>
@endforeach
</div>
@endif
@endif

<div class="multiselect-action mb-3 d-flex hidden">
    <div>
        <button id="multiselect_approve" type="button" class="btn btn-primary btn-icon-text"><i class="btn-icon-prepend" icon-name="check-circle-2"></i>{{ __( 'datatables.approve' ) }}</button>&nbsp;<button id="multiselect_reject" type="button" class="btn btn-danger btn-icon-text"><i class="btn-icon-prepend" icon-name="x-circle"></i>{{ __( 'datatables.reject' ) }}</button>
    </div>
</div>

<table class="table table-striped nowrap" style="width: 100%;" {{ $attributes }}>
    <thead>
        
        <tr>
            @foreach ( $columns as $key => $column )
            @if ( $key == 0 )
            @if ( @$column->multi_select == 'yes' )
            <th><input class="select-all" type="checkbox" style="width: 100%"></th>
            @else
            <th>{{ $column->title }}</th>
            @endif
            @else
            <th>{{ $column->title }}</th>
            @endif
            @endforeach
        </tr>
    </thead>
    <tbody></tbody>
    @if ( $enableFooter == 'true' )
    <tfoot>
        <tr>
            @foreach ( $columns as $key => $column )
            @if ( @$column->preAmount )
            <th style="text-align: end !important;">{{ __( 'datatables.sub_total' ) }}</th>
            @continue
            @endif
            @if ( @$column->amount )
            <th class="subtotal text-end"></th>
            @continue
            @endif
            <th></th>
            @endforeach
        </tr>
        <tr>
            @foreach ( $columns as $key => $column )
            @if ( @$column->preAmount )
            <th class="text-end">{{ __( 'datatables.grand_total' ) }}</th>
            @continue
            @endif
            @if ( @$column->amount )
            <th class="grandtotal text-end"></th>
            @continue
            @endif
            <th></th>
            @endforeach
        </tr>
    </tfoot>
    @endif
</table>

<?php

function renderFilter( $type, $column = [] ) {

    switch ( $type ) {
        case 'input':
            $html = '<input type="text" class="form-control" placeholder="' . $column->placeholder . '" id="' . $column->id . '" data-id="'.$column->id.'" />';
            break;
        case 'date':
            $html = '<div class="filter-date-wrapper">';
            $html .= '<input type="text" class="form-control" placeholder="' . $column->placeholder . '" id="' . $column->id . '" data-id="'.$column->id.'" style="background-color: #fff;" />';
            $html .= '<i id="clear_date" icon-name="x" stroke="#495057" data-id="' . \Str::camel( $column->id ) . '"></i>';
            $html .= '</div>';
            break;
        case 'select':
            $html = '<select class="form-control" data-id="'.$column->id.'" id="' . $column->id . '">';
            foreach ( $column->options as $option ) {
                $html .= '<option value="' . $option->value . '">' . $option->title . '</option>';
            }
            $html .= '</select>';
            break;
        default:
            $html = '';
            break;
    }

    return $html;
}

?>