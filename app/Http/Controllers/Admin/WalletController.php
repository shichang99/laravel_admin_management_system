<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\{
    WalletService,
};

use Helper;

class WalletController extends Controller
{
    public function index() {

        $this->data['content'] = 'admin.wallet.index';

        return view( 'admin.main' )->with( $this->data );
    }

    public function statement() {

        $this->data['content'] = 'admin.wallet.statement';

        return view( 'admin.main' )->with( $this->data );
    }

    public function topup() {

        $this->data['content'] = 'admin.wallet.topup';

        return view( 'admin.main' )->with( $this->data );
    }

    public function withdrawal() {

        $this->data['content'] = 'admin.wallet.withdrawal';

        return view( 'admin.main' )->with( $this->data );
    }

    public function allMemberWallets( Request $request, $export = false ) {

        return WalletService::allMemberWallets( $request, $export );
    }

    public function oneMemberWallet( Request $request ) {

        return WalletService::oneMemberWallet( $request );
    }

    public function updateMemberWallet( Request $request ) {

        return WalletService::updateMemberWallet( $request );
    }

    public function allMemberStatements( Request $request, $export = false ) {

        return WalletService::allMemberStatements( $request, $export );
    }
    
    public function allMemberTopups( Request $request, $export = false ) {

        return WalletService::allMemberTopups( $request, $export );
    }

    public function updateApproveTopup( Request $request ) {

        return WalletService::updateApproveTopup( $request );
    }

    public function updateRejectTopup( Request $request ) {

        return WalletService::updateRejectTopup( $request );
    }

    public function allMemberWithdrawals( Request $request, $export = false ) {

        return WalletService::allMemberWithdrawals( $request, $export );
    }
    
    public function updateApproveWithdrawal( Request $request ) {

        return WalletService::updateApproveWithdrawal( $request );
    }

    public function updateRejectWithdrawal( Request $request ) {

        return WalletService::updateRejectWithdrawal( $request );
    }

    public function exportWalletListing( Request $request ) {

        $wallets = $this->allMemberWallets( $request, true );

        $wType = Helper::walletName();

        $html = '<table>';
        $html .= '
        <thead>
            <tr>
                <th><strong>No.</strong></th>
                <th><strong>'.__( 'wallet.username' ).'</strong></th>
                <th><strong>'.__( 'wallet.wallet_type' ).'</strong></th>
                <th><strong>'.__( 'wallet.balance' ).'</strong></th>
                
            </tr>
        </thead>
        ';
        $html .= '<tbody>';

        foreach ( $wallets as $key => $wallet ) {
            $html .=
            '
            <tr>
                <td>' . ( $key + 1 ) . '</td>
                <td>' . $wallet->user->name . '</td>
                <td>' . $wType[$wallet->type] . '</td>
                <td>' . $wallet->balance . '</td>

            ';
        }

        $html .= '</tbody></table>';
        

        Helper::exportReport( $html, 'WalletStatement' );
    }

    public function exportWalletStatement( Request $request ) {

        $transactions = $this->allMemberStatements( $request, true );

        $wType = Helper::walletName();

        $html = '<table>';
        $html .= '
        <thead>
            <tr>
                <th><strong>No.</strong></th>
                <th><strong>'.__( 'datatables.created_date' ).'</strong></th>
                <th><strong>'.__( 'member.username' ).'</strong></th>
                <th><strong>'.__( 'wallet.wallet_type' ).'</strong></th>
                <th><strong>'.__( 'wallet.remark' ).'</strong></th>
                <th><strong>'.__( 'wallet.amount' ).'</strong></th>
                
            </tr>
        </thead>
        ';
        $html .= '<tbody>';

        foreach ( $transactions as $key => $transaction ) {
            $html .=
            '
            <tr>
                <td>' . ( $key + 1 ) . '</td>
                <td>' . $transaction->created_at . '</td>
                <td>' . $transaction->user->name . '</td>
                <td>' . $wType[$transaction->type] . '</td>
                <td>' . $transaction->converted_remark . '</td>
                <td>' . $transaction->amount . '</td>

            ';
        }

        $html .= '</tbody></table>';
        

        Helper::exportReport( $html, 'WalletStatement' );
    }

    public function exportWalletTopups( Request $request ) {

        $transactions = $this->allMemberTopups( $request, true );

        $wType = Helper::walletName();

        $html = '<table>';
        $html .= '
        <thead>
            <tr>
                <th><strong>No.</strong></th>
                <th><strong>'.__( 'datatables.created_date' ).'</strong></th>
                <th><strong>'.__( 'member.username' ).'</strong></th>
                <th><strong>'.__( 'wallet.wallet_type' ).'</strong></th>
                <th><strong>'.__( 'wallet.payment_method' ).'</strong></th>
                <th><strong>'.__( 'wallet.remark' ).'</strong></th>
                <th><strong>'.__( 'datatables.status' ).'</strong></th>
                <th><strong>'.__( 'wallet.amount' ).'</strong></th>
            </tr>
        </thead>
        ';
        $html .= '<tbody>';

        $status = [
            '0' => __( 'datatables.pending' ),
            '1' => __( 'datatables.approved' ),
            '9' => __( 'datatables.rejected' ),
            '10' => __( 'member.cancelled' ),
        ];

        foreach ( $transactions as $key => $transaction ) {
            $html .=
            '
            <tr>
                <td>' . ( $key + 1 ) . '</td>
                <td>' . $transaction->created_at . '</td>
                <td>' . $transaction->user->name . '</td>
                <td>' . $wType[$transaction->type] . '</td>
                <td>' . ( $transaction->payment_method == 1 ? __( 'wallet.slip_topup' ) : __( 'wallet.topup' ) ) . '</td>
                <td>' . ( $transaction->status == 1 ? $transaction->remark : '-' ) . '</td>
                <td>' . $status[$transaction->status] . '</td>
                <td>' . $transaction->amount . '</td>


            ';
        }

        $html .= '</tbody></table>';
        

        Helper::exportReport( $html, 'TopUpStatement' );
    }

    public function exportWalletWithdrawals( Request $request ) {

        $transactions = $this->allMemberWithdrawals( $request, true );

        $wType = Helper::walletName();

        $html = '<table>';
        $html .= '
        <thead>
            <tr>
                <th><strong>No.</strong></th>
                <th><strong>'.__( 'datatables.created_date' ).'</strong></th>
                <th><strong>'.__( 'member.username' ).'</strong></th>
                <th><strong>'.__( 'wallet.wallet_type' ).'</strong></th>
                <th><strong>'.__( 'wallet.withdraw_method' ).'</strong></th>
                <th><strong>'.__( 'wallet.withdraw_detail' ).'</strong></th>
                <th><strong>'.__( 'wallet.amount' ).'</strong></th>
                <th><strong>'.__( 'wallet.processing_fee' ).'</strong></th>
                <th><strong>'.__( 'wallet.actual_amount' ).'</strong></th>
                <th><strong>'.__( 'wallet.remark' ).'</strong></th>
                <th><strong>'.__( 'datatables.status' ).'</strong></th>
            </tr>
        </thead>
        ';
        $html .= '<tbody>';

        $status = [
            '0' => __( 'datatables.pending' ),
            '1' => __( 'datatables.approved' ),
            '9' => __( 'datatables.rejected' ),
            '10' => __( 'member.cancelled' ),
        ];

        $methods = [
            '1' => __( 'wallet.withdraw_method_1' ),
            '2' => __( 'wallet.withdraw_method_2' ),
            '3' => __( 'wallet.withdraw_method_3' ),
            '4' => __( 'wallet.withdraw_method_4' ),
        ];

        foreach ( $transactions as $key => $transaction ) {
            // $status_name = "";
            // switch($transaction->status) {
            //     case '0':
            //         $status_name = "Pending";
            //         break;

            //     case '1':
            //         $status_name = "Approved";
            //         break;

            //     case '9':
            //         $status_name = "Rejected";
            //         break;

            //     default:
            //         $status_name = "Cancelled";
            //         break;
            // }
            $detail = json_decode($transaction->member_bank_detail);
            if ($transaction->withdraw_method == 1) {
                $bank_detail = __( 'member.bank_name' ).': ' . $detail->bank_name . '<br>' . 
                                __( 'member.branch_name' ).': ' . $detail->branch_name . '<br>' . 
                                __( 'member.bank_number' ).': ' . $detail->bank_number . '<br>' . 
                                __( 'member.account_name' ).': ' . $detail->account_name . '<br>';
            } else {
                $bank_detail = __( 'member.usdt_type' ).': TRC20 <br>' . 
                                __( 'member.usdt_address' ).': ' . $detail->usdt_address . '<br>';
            }

            $html .=
            '
            <tr>
                <td>' . ( $key + 1 ) . '</td>
                <td>' . $transaction->created_at . '</td>
                <td>' . $transaction->user->name . '</td>
                <td>' . $wType[$transaction->wallet_type] . '</td>
                <td>' . $methods[$transaction->withdraw_method] . '</td>
                <td>' . $bank_detail . '</td>
                <td>' . $transaction->original_amount . '</td>
                <td>' . $transaction->original_process_fee . '</td>
                <td>' . $transaction->original_actual_amount . '</td>
                <td>' . ( $transaction->remark ? $transaction->remark : '-' ) . '</td>
                <td>' . $status[$transaction->status] . '</td>
            ';
        }

        $html .= '</tbody></table>';
        

        Helper::exportReport( $html, 'WithdrawalStatement' );
    }
}
