<?php
$result = $data;
// var_dump( $result );
?>
{{-- <div class="listing-header">
    <h3>{{ __( 'template.dashboard' ) }}</h3>
</div>
<br> --}}

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __( 'template.dashboard' ) }}</h3>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title mb-3">Latest 7 Days Summary</h6>
                        <div id="monthlySalesChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h3>Community</h3>
                    </div>
                    <div class="col-xl-12 grid-margin stretch-card">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Most Members</h6>
                            @foreach ( @$result['most_members'] as $u )
                            <div class="shadow-sm py-2 px-3 mb-3 bg-body rounded">
                                <div>
                                    <strong>{{ $u['name'] }}</strong>
                                </div>
                                <div>
                                    <small>{{ $u['total_account'] }} Member(s)</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="card-body">
                            <h6 class="card-title mb-3">Highest Sales</h6>
                            @foreach ( @$result['highest_sales'] as $u )
                            <div class="shadow-sm py-2 px-3 mb-3 bg-body rounded">
                                <div>
                                    <strong>{{ $u['name'] }}</strong>
                                </div>
                                <div>
                                    <small>{{ Helper::currencyFormat( $u['total_bounding_sales'], 2 ) }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="card-body">
                            <h6 class="card-title mb-3">Highest Topup</h6>
                            @foreach ( @$result['highest_topup'] as $u )
                            <div class="shadow-sm py-2 px-3 mb-3 bg-body rounded">
                                <div>
                                    <strong>{{ $u['name'] }}</strong>
                                </div>
                                <div>
                                    <small>{{ Helper::currencyFormat( $u['total_deposit'], 2 ) }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-2">Total Members</h6>
                            <div class="bg-info" style="border-radius: 30px; padding: 8px;">
                                <i icon-name="users" width="20px" height="20px" fill="#fff"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h4 class="mb-2">{{ @$result['total_members']['total'] }}</h3>
                                <div class="d-flex justify-content-between align-items-baseline">
                                    @if ( @$result['total_members']['percentage'] < 0 )
                                    <p class="text-danger">
                                        <span>-{{ @$result['total_members']['percentage'] }}%</span>
                                        <i icon-name="arrow-down" class="icon-sm mb-1"></i>
                                    </p>
                                    @elseif ( @$result['total_members']['percentage'] == 0 )
                                    <p class="text-secondary">
                                    <span>{{ @$result['total_members']['percentage'] }}%</span>
                                        <i icon-name="chevrons-left-right" class="icon-sm mb-1"></i>
                                    </p>
                                    @else
                                    <p class="text-success">
                                        <span>+{{ @$result['total_members']['percentage'] }}%</span>
                                        <i icon-name="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <div>
                                    Last Register: 
                                </div>
                                <div>
                                    {{ @$result['total_members']['last_register'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-2">Total Active Members</h6>
                            <div class="bg-primary" style="border-radius: 30px; padding: 8px;">
                                <i icon-name="users" width="20px" height="20px" fill="#fff"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h4 class="mb-2">{{ @$result['active_members']['total'] }}</h3>
                                <div class="d-flex justify-content-between align-items-baseline">
                                    @if ( @$result['active_members']['percentage'] < 0 )
                                    <p class="text-danger">
                                        <span>-{{ @$result['active_members']['percentage'] }}%</span>
                                        <i icon-name="arrow-down" class="icon-sm mb-1"></i>
                                    </p>
                                    @elseif ( @$result['active_members']['percentage'] == 0 )
                                    <p class="text-secondary">
                                    <span>{{ @$result['active_members']['percentage'] }}%</span>
                                        <i icon-name="chevrons-left-right" class="icon-sm mb-1"></i>
                                    </p>
                                    @else
                                    <p class="text-success">
                                        <span>+{{ @$result['active_members']['percentage'] }}%</span>
                                        <i icon-name="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <div>
                                    Last Register: 
                                </div>
                                <div>
                                    {{ @$result['active_members']['last_register'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-2">Total Sales</h6>
                            <div class="bg-secondary" style="border-radius: 30px; padding: 8px;">
                                <i icon-name="building-2" width="20px" height="20px" fill="#fff"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h4 class="mb-2">{{ Helper::currencyFormat( @$result['total_sales']['total'], 2 ) }}</h3>
                                <div class="d-flex align-items-baseline">
                                    @if ( @$result['total_sales']['percentage'] < 0 )
                                    <p class="text-danger">
                                        <span>-{{ @$result['total_sales']['percentage'] }}%</span>
                                        <i icon-name="arrow-down" class="icon-sm mb-1"></i>
                                    </p>
                                    @elseif ( @$result['total_sales']['percentage'] == 0 )
                                    <p class="text-secondary">
                                    <span>{{ @$result['total_sales']['percentage'] }}%</span>
                                        <i icon-name="chevrons-left-right" class="icon-sm mb-1"></i>
                                    </p>
                                    @else
                                    <p class="text-success">
                                        <span>+{{ @$result['total_sales']['percentage'] }}%</span>
                                        <i icon-name="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-2">Total Topup</h6>
                            <div class="bg-success" style="border-radius: 30px; padding: 8px;">
                                <i icon-name="chevrons-down" width="20px" height="20px" fill="#fff" stroke="#fff"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h4 class="mb-2">{{ Helper::currencyFormat( @$result['topup']['total'], 2 ) }}</h3>
                                <div class="d-flex align-items-baseline">
                                    @if ( @$result['topup']['percentage'] < 0 )
                                    <p class="text-danger">
                                        <span>-{{ $result['topup']['percentage'] }}%</span>
                                        <i icon-name="arrow-down" class="icon-sm mb-1"></i>
                                    </p>
                                    @elseif ( @$result['topup']['percentage'] == 0 )
                                    <p class="text-secondary">
                                    <span>{{ @$result['topup']['percentage'] }}%</span>
                                        <i icon-name="chevrons-left-right" class="icon-sm mb-1"></i>
                                    </p>
                                    @else
                                    <p class="text-success">
                                        <span>+{{ @$result['topup']['percentage'] }}%</span>
                                        <i icon-name="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <div>
                                    Last Topup: 
                                </div>
                                <div>
                                    {{ @$result['topup']['last_topup'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-2">Total Withdraw</h6>
                            <div class="bg-danger" style="border-radius: 30px; padding: 8px;">
                                <i icon-name="chevrons-up" width="20px" height="20px" fill="#fff" stroke="#fff"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h4 class="mb-2">{{ Helper::currencyFormat( @$result['withdrawal']['total'], 2 ) }}</h3>
                                <div class="d-flex align-items-baseline">
                                    @if ( @$result['withdrawal']['percentage'] < 0 )
                                    <p class="text-danger">
                                        <span>-{{ @$result['withdrawal']['percentage'] }}%</span>
                                        <i icon-name="arrow-down" class="icon-sm mb-1"></i>
                                    </p>
                                    @elseif ( @$result['withdrawal']['percentage'] == 0 )
                                    <p class="text-secondary">
                                    <span>{{ @$result['withdrawal']['percentage'] }}%</span>
                                        <i icon-name="chevrons-left-right" class="icon-sm mb-1"></i>
                                    </p>
                                    @else
                                    <p class="text-success">
                                        <span>+{{ @$result['withdrawal']['percentage'] }}%</span>
                                        <i icon-name="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <div>
                                    Last Withdraw: 
                                </div>
                                <div>
                                    {{ @$result['withdrawal']['last_withdrawal'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset( 'admin/js/apexcharts.min.js' ) . Helper::assetVersion() }}"></script>
<script>
    document.addEventListener( 'DOMContentLoaded', function() {

        var colors = {
            primary        : "#6571ff",
            secondary      : "#7987a1",
            success        : "#05a34a",
            info           : "#66d1d1",
            warning        : "#fbbc06",
            danger         : "#ff3366",
            light          : "#e9ecef",
            dark           : "#060c17",
            muted          : "#7987a1",
            gridBorder     : "rgba(77, 138, 240, .15)",
            bodyColor      : "#000",
            cardBg         : "#fff"
        }

        let a2 = @json( $result['last_7_days']['a2'] );
        let a3 = @json( $result['last_7_days']['a3'] );
        let b = @json( $result['last_7_days']['b'] );

         // Monthly Sales Chart
        if( $('#monthlySalesChart').length) {
            var options = {
                chart: {
                    type: 'bar',
                    height: '318',
                    parentHeightOffset: 0,
                    foreColor: colors.bodyColor,
                    background: colors.cardBg,
                    toolbar: {
                    show: false
                    },
                },
                theme: {
                    mode: 'light'
                },
                tooltip: {
                    theme: 'light'
                },
                colors: [colors.info, colors.warning],  
                fill: {
                    opacity: .9
                } , 
                grid: {
                    padding: {
                    bottom: -4
                    },
                    borderColor: colors.gridBorder,
                    xaxis: {
                    lines: {
                        show: true
                    }
                    }
                },
                series: [
                    {
                      name: 'Total Topup',
                      data: a2,
                    },
                    {
                      name: 'Total Withdrawal',
                      data: a3,
                    },
                ],
                xaxis: {
                    // type: 'datetime',
                    categories: b,
                    axisBorder: {
                    color: colors.gridBorder,
                    },
                    axisTicks: {
                    color: colors.gridBorder,
                    },
                },
                yaxis: {
                    title: {
                    text: '',
                    style:{
                        size: 9,
                        color: colors.muted
                    }
                    },
                },
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'right',

                    itemMargin: {
                    horizontal: 8,
                    vertical: 0
                    },
                },
                stroke: {
                    width: 0
                },
                dataLabels: {
                    enabled: true,
                    style: {
                    fontSize: '10px',

                    },
                    offsetY: -35
                },
                plotOptions: {
                    bar: {
                    columnWidth: "50%",
                    borderRadius: 4,
                    dataLabels: {
                        position: 'top',
                        orientation: 'vertical',
                    }
                    },
                },
            }
            
            var apexBarChart = new ApexCharts(document.querySelector("#monthlySalesChart"), options);

            apexBarChart.render();
        }
        // Monthly Sales Chart - END
    } );
</script>