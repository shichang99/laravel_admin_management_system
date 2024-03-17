<?php

namespace App\Services;

use App\Models\{
    Order,
    User,
    MemberTopup,
    TrxRequest,
};

class DashboardService {

    public function dashboardData() {

        $last7DaysOrder = [];

        $a1 = [];
        $a2 = [];
        $a3 = [];
        $b = [];

        for ( $x = 6; $x >= 0; $x-- ) {

            $day = strtotime( 'now -' . $x . ' day' );

            $thisDate = new \DateTime( date( 'Y-m-d', $day ) );

            // $totalSales = Order::whereBetween( 'created_at', [ $thisDate->format( 'Y-m-d' ) . ' 00:00:00', $thisDate->format( 'Y-m-d' ) . ' 23:59:59' ] )->where( 'status', 1 )->sum( 'amount' );
            $totalTopup = MemberTopup::whereBetween( 'created_at', [ $thisDate->format( 'Y-m-d' ) . ' 00:00:00', $thisDate->format( 'Y-m-d' ) . ' 23:59:59' ] )->where( 'status', 1 )->sum( 'amount' );
            $totalWithdrawal = TrxRequest::whereBetween( 'created_at', [ $thisDate->format( 'Y-m-d' ) . ' 00:00:00', $thisDate->format( 'Y-m-d' ) . ' 23:59:59' ] )->where( 'status', 1 )->sum( 'original_amount' );

            // $last7DaysOrder[] = [
            //     'total' => $totalOrder,
            //     'humanDate' => $thisDate->format( 'M d' ),
            // ];
            // $a1[] = $totalSales;
            $a2[] = $totalTopup;
            $a3[] = $totalWithdrawal;
            $b[] = $thisDate->format( 'M d' );
        }

        $data['last_7_days'] = [
            // 'a1' => $a1,
            'a2' => $a2,
            'a3' => $a3,
            'b' => $b,
        ];

        // $communities = Community::with( 'user' )->get();
        // // Most Members
        // $most_members = $communities->sortByDesc(function($community){
        //     return $community->total_account;
        // });
        // $most_members = $most_members->filter(function($community){
        //     return $community->total_account >= 1 == true;
        // });
        // $most_members = $most_members->take(5);

        // // Highest Sales
        // $highest_sales = $communities->sortByDesc(function($community){
        //     return $community->total_bounding_sales;
        // });
        // $highest_sales = $highest_sales->filter(function($community){
        //     return $community->total_bounding_sales >= 1 == true;
        // });
        // $highest_sales = $highest_sales->take(5);

        // // Highest Topup
        // $highest_topup = $communities->sortByDesc(function($community){
        //     return $community->total_deposit;
        // });
        // $highest_topup = $highest_topup->filter(function($community){
        //     return $community->total_deposit >= 1 == true;
        // });
        // $highest_topup = $highest_topup->take(5);

        $data['most_members']   = []; // $most_members->toArray();
        $data['highest_sales']  = []; // $highest_sales->toArray();
        $data['highest_topup']  = []; // $highest_topup->toArray();

        $today = date( 'Y-m-d' );
        $lastMonth = new \DateTime( $today );
        $lastMonth->modify( '-1 month' );
        $lastMonthFirst = $lastMonth->modify( 'first day of this month' )->format( 'Y-m-d' );
        $lastMonthLast = $lastMonth->modify( 'last day of this month' )->format( 'Y-m-d' );

        $currentMonth = new \DateTime( $today );
        $currentMonthFirst = $currentMonth->modify( 'first day of this month' )->format( 'Y-m-d' );
        $currentMonthLast = $currentMonth->modify( 'last day of this month' )->format( 'Y-m-d' );

        $totalLastMonthUser = User::where( 'created_at', '<=', $lastMonthLast . ' 23:59:59' )->count();
        $totalCurrentMonthUser = User::where( 'created_at', '<=', $currentMonthLast . ' 23:59:59' )->count();
        $lastRegister = User::orderBy( 'created_at', 'DESC' )->first();

        $data['total_members'] = [
            'total' => $totalCurrentMonthUser,
            'last_register' => date( 'Y-m-d', strtotime( $lastRegister->created_at ) ),
            'percentage' => self::calculatePercentage( $totalCurrentMonthUser, $totalLastMonthUser ),
        ];

        $totalLastMonthActiveUser = User::where( 'capital', '>', 0 )->where( 'status', 1 )->where( 'created_at', '<=', $lastMonthLast . ' 23:59:59' )->count();
        $totalCurrentMonthActiveUser = User::where( 'capital', '>', 0 )->where( 'status', 1 )->where( 'created_at', '<=', $currentMonthLast . ' 23:59:59' )->count();
        $lastActiveRegister = User::where( 'capital', '>', 0 )->where( 'status', 1 )->orderBy( 'created_at', 'DESC' )->first();

        $data['active_members'] = [
            'total' => $totalCurrentMonthActiveUser,
            'last_register' => $lastActiveRegister ? date( 'Y-m-d', strtotime( $lastActiveRegister->created_at ) ) : '-',
            'percentage' => self::calculatePercentage( $totalCurrentMonthActiveUser, $totalLastMonthActiveUser ),
        ];

        // $totalSalesLastMonthUser = Order::where( 'created_at', '<=', $lastMonthLast . ' 23:59:59' )->where( 'status', 1 )->sum( 'amount' );
        // $totalSalesCurrentMonthUser = Order::where( 'created_at', '<=', $currentMonthLast . ' 23:59:59' )->where( 'status', 1 )->sum( 'amount' );

        // $data['total_sales'] = [
        //     'total' => $totalSalesCurrentMonthUser,
        //     'percentage' => self::calculatePercentage( $totalSalesCurrentMonthUser, $totalSalesLastMonthUser ),
        // ];

        $totalLastMonthTopup = MemberTopup::where( 'created_at', '<=', $lastMonthLast . ' 23:59:59' )->where( 'status', 1 )->sum( 'amount' );
        $totalCurrentMonthTopup = MemberTopup::where( 'created_at', '<=', $currentMonthLast . ' 23:59:59' )->where( 'status', 1 )->sum( 'amount' );
        $lastTopup = MemberTopup::where( 'status', 1 )->orderBy( 'created_at', 'DESC' )->first();

        $data['topup'] = [
            'total' => $totalCurrentMonthTopup,
            'last_topup' => $lastTopup ? date( 'Y-m-d', strtotime( $lastTopup->created_at ) ) : '-',
            'percentage' => self::calculatePercentage( $totalCurrentMonthTopup, $totalLastMonthTopup ),
        ];

        $totalLastMonthWithdrawal = TrxRequest::where( 'created_at', '<=', $lastMonthLast . ' 23:59:59' )->where( 'status', 1 )->sum( 'original_amount' );
        $totalCurrentMonthWithdrawal = TrxRequest::where( 'created_at', '<=', $currentMonthLast . ' 23:59:59' )->where( 'status', 1 )->sum( 'original_amount' );
        $lastWithdrawal = TrxRequest::where( 'status', 1 )->orderBy( 'created_at', 'DESC' )->first();

        $data['withdrawal'] = [
            'total' => $totalCurrentMonthWithdrawal,
            'last_withdrawal' => $lastWithdrawal ? date( 'Y-m-d', strtotime( $lastWithdrawal->created_at ) ) : '-',
            'percentage' => self::calculatePercentage( $totalCurrentMonthWithdrawal, $totalLastMonthWithdrawal ),
        ];

        return $data;
    }

    private function calculatePercentage( $current, $last ) {

        if ( $current == 0 && $last == 0 ) {
            $d = 0;
            return $d;
        }

        if ( $last == 0 ) {
            $d = 100;
        } else {
            $d = $current - $last;
            $d = $d / $last * 100;
        }

        return number_format( $d, 2 );
    }
}