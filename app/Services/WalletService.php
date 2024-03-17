<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\{
    User,
    MemberTopup,
    MemberWallet,
    MemberWalletTransaction,
    TrxRequest,
    SysSetting,
};

use App\Rules\{
    CheckSecurityPinRule,
    CheckMathModuloRule
};

use Helper;

class WalletService {

    public function allMemberWallets( $request, $export ) {

        $filter = false;

        $memberWallet = MemberWallet::with( 'user' )->select( 'member_wallets.*' );
        $memberWallet->leftJoin( 'users', 'users.id', '=', 'member_wallets.user_id' );

        if ( !empty( $request->username ) ) {
            $memberWallet->where( 'users.name', $request->username );
            $filter = true;
        }

        if ( !empty( $request->wallet_type ) ) {
            $memberWallet->where( 'member_wallets.type', $request->wallet_type );
            $filter = true;
        }

        $memberWallet->orderBy( 'member_wallets.user_id', 'DESC' )->orderBy( 'member_wallets.type', 'ASC' );

        if ( $export == false ) {

            $memberWalletCount = $memberWallet->count();

            $limit = $request->input( 'length' );
            $offset = $request->input( 'start' );

            $memberWalletObject = $memberWallet->skip( $offset )->take( $limit );
            $memberWallets = $memberWalletObject->get();

            $pageTotalAmount = 0;
            foreach ( $memberWallets->toArray() as $mw ) {
                $pageTotalAmount += $mw['balance'];
            }

            $memberWallet = MemberWallet::select(
                \DB::raw( 'COUNT(member_wallets.id) as total,
                SUM(balance) as grandTotal1'
            ) );
            $memberWallet->leftJoin( 'users', 'users.id', '=', 'member_wallets.user_id' );

            if ( !empty( $request->username ) ) {
                $memberWallet->where( 'users.name', $request->username );
                $filter = true;
            }
    
            if ( !empty( $request->wallet_type ) ) {
                $memberWallet->where( 'member_wallets.type', $request->wallet_type );
                $filter = true;
            }

            $memberWallet = $memberWallet->first();
            
            $data = [
                'member_wallets' => $memberWallets,
                'draw' => $request->draw,
                'recordsFiltered' => $filter ? $memberWalletCount : $memberWallet->total,
                'recordsTotal' => MemberWallet::select( \DB::raw( 'COUNT(id) as total' ) )->first()->total,
                'subTotal' => [
                    Helper::currencyFormat( $pageTotalAmount, 4 )
                ],
                'grandTotal' => [
                    Helper::currencyFormat( $memberWallet->grandTotal1, 4 )
                ],
            ];

            return $data;
        } else {
            return $memberWallet->get();
        }
    }

    public function oneMemberWallet( $request ) {

        $memberWallet = MemberWallet::with( [ 'user' ] )->find( $request->id );

        return response()->json( $memberWallet );
    }

    public function updateMemberWallet( $request ) {

        $request->validate( [
            'id' => 'required|exists:member_wallets,id',
            'amount' => 'required',
            'remark' => 'required|string',
        ] );

        \DB::beginTransaction();

        try {

            $memberWallet = MemberWallet::lockForUpdate()->find( $request->id );

            self::transact( $memberWallet, [
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'amount' => $request->amount,
                'remark' => $request->remark,
                'trx_type' => 9,
            ] );
            \DB::commit();

        } catch ( \Throwable $th ) {
            \DB::rollBack();
            abort( 500, $th->getMessage() . ' in line: ' . $th->getLine() );
        }
    }

    public function allMemberStatements( $request, $export ) {
        
        $filter = false;
        $transaction = MemberWalletTransaction::with( [ 'user' ] )->select( 'member_wallet_transactions.*' );
        $transaction->leftJoin( 'users', 'users.id', '=', 'member_wallet_transactions.user_id' );
    
        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $transaction->whereBetween( 'member_wallet_transactions.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $transaction->whereBetween( 'member_wallet_transactions.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        $transaction->where('member_wallet_transactions.status',1);
        if ( !empty( $request->username ) ) {
            $transaction->where( 'users.name', $request->username );
            $filter = true;
        }

        if ( !empty( $request->wallet_type ) ) {
            $transaction->where( 'member_wallet_transactions.type', $request->wallet_type );
            $filter = true;
        }

        if ( !empty( $request->trxtype ) ) {
            $transaction->whereIn( 'member_wallet_transactions.trx_type', explode( ',', $request->trxtype ) );
            $filter = true;
        }

        if ( $request->input( 'order.0.column' ) != 0 ) {

            switch ( $request->input( 'order.0.column' ) ) {
                case 1:
                    $transaction->orderBy( 'member_wallet_transactions.created_at', $request->input( 'order.0.dir' ) );
                    $transaction->orderBy( 'member_wallet_transactions.id', 'DESC' );
                    break;
                case 3:
                    $transaction->orderBy( 'member_wallet_transactions.type', $request->input( 'order.0.dir' ) );
                    break;
                case 5:
                    $transaction->orderBy( 'member_wallet_transactions.amount', $request->input( 'order.0.dir' ) );
                    break;
            }
        }
        
        if ( $export == false ) {

            $transactionCount = $transaction->count();

            $limit = $request->input( 'length' );
            $offset = $request->input( 'start' );

            $transactionObject = $transaction->skip( $offset )->take( $limit );
            $transactions = $transactionObject->get();

            $pageTotalAmount = 0;
            foreach ( $transactions->toArray() as $t ) {
                $pageTotalAmount += $t['amount'];
            }
           
            $transaction = MemberWalletTransaction::select(
                \DB::raw( 'COUNT(member_wallet_transactions.id) as total,
                SUM(amount) as grandTotal1'
            ) );
            $transaction->leftJoin( 'users', 'users.id', '=', 'member_wallet_transactions.user_id' );

            if ( !empty( $request->created_date ) ) {
                if ( str_contains( $request->created_date, 'to' ) ) {
                    $dates = explode( ' to ', $request->created_date );
                    $transaction->whereBetween( 'member_wallet_transactions.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
                } else {
                    $transaction->whereBetween( 'member_wallet_transactions.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
                }
                $filter = true;
            }

            if ( !empty( $request->username ) ) {
                $transaction->where( 'users.name', $request->username );
                $filter = true;
            }
    
            if ( !empty( $request->wallet_type ) ) {
                $transaction->where( 'member_wallet_transactions.type', $request->wallet_type );
                $filter = true;
            }

            if ( !empty( $request->trxtype ) ) {
                $transaction->whereIn( 'member_wallet_transactions.trx_type', explode( ',', $request->trxtype ) );
                $filter = true;
            }

            $transaction = $transaction->first();

            $data = [
                'transactions' => $transactions,
                'draw' => $request->draw,
                'recordsFiltered' => $filter ? $transactionCount : $transaction->total,
                'recordsTotal' => $transactionCount,
                'subTotal' => [
                    Helper::currencyFormat( $pageTotalAmount, 4 )
                ],
                'grandTotal' => [
                    Helper::currencyFormat( $transaction->grandTotal1, 4 )
                ],
            ];

            return $data;
        } else {

            return $transaction->get();
        }
    }

    public function allMemberTopups( $request, $export ) {

        $filter = false;

        $memberTopup = MemberTopup::with( 'user' )->select( 'member_topups.*' );
        $memberTopup->leftJoin( 'users', 'users.id', '=', 'member_topups.user_id' );

        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $memberTopup->whereBetween( 'member_topups.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $memberTopup->whereBetween( 'member_topups.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }
        if ( !empty( $request->username ) ) {
            $memberTopup->where( 'users.name', $request->username );
            $filter = true;
        }

        if ( $request->status == 0 && $request->status != '' ) {
            $memberTopup->where( 'member_topups.status', $request->status );
            $filter = true;
        } else {
            if ( !empty( $request->status ) ) {
                $memberTopup->where( 'member_topups.status', $request->status );
                $filter = true;
            }
        }

        $memberTopup->orderBy( 'member_topups.created_at', 'DESC' );

        if ( $export == false ) {

            $memberTopupCount = $memberTopup->count();

            $limit = $request->input( 'length' );
            $offset = $request->input( 'start' );

            $memberTopupObject = $memberTopup->skip( $offset )->take( $limit );
            $memberTopups = $memberTopupObject->get();

            $pageTotalAmount = 0;
            foreach ( $memberTopups->toArray() as $mt ) {
                $pageTotalAmount += $mt['amount'];
            }

            $memberTopup = MemberTopup::select(
                \DB::raw( 'COUNT(member_topups.id) as total,
                SUM(amount) as grandTotal1'
            ) );
            $memberTopup->leftJoin( 'users', 'users.id', '=', 'member_topups.user_id' );

            if ( !empty( $request->created_date ) ) {
                if ( str_contains( $request->created_date, 'to' ) ) {
                    $dates = explode( ' to ', $request->created_date );
                    $memberTopup->whereBetween( 'member_topups.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
                } else {
                    $memberTopup->whereBetween( 'member_topups.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
                }
                $filter = true;
            }
    
            if ( !empty( $request->username ) ) {
                $memberTopup->where( 'users.name', $request->username );
                $filter = true;
            }
    
            if ( !empty( $request->status ) ) {
                $memberTopup->where( 'member_topups.status', $request->status );
                $filter = true;
            }

            $memberTopup = $memberTopup->first();
            
            $data = [
                'member_topups' => $memberTopups,
                'draw' => $request->draw,
                'recordsFiltered' => $filter ? $memberTopupCount : $memberTopup->total,
                'recordsTotal' => MemberTopup::select( \DB::raw( 'COUNT(id) as total' ) )->first()->total,
                'subTotal' => [
                    Helper::currencyFormat( $pageTotalAmount, 4 )
                ],
                'grandTotal' => [
                    Helper::currencyFormat( $memberTopup->grandTotal1, 4 )
                ],
            ];

            return $data;
        } else {
            return $memberTopup->get();
        }
    }

    public function updateApproveTopup( $request ) {

        $request->validate( [
            'remark' => 'required|string',
        ] );

        \DB::beginTransaction();

        try {

            $memberTopupIds = ( Str::contains($request->ids, ',') ? explode( ',', $request->ids ) : explode( ' ', $request->ids ) );

            for ( $i = 0; $i < count( $memberTopupIds ); $i++ ) {

                $memberTopup = MemberTopup::lockForUpdate()->find( $memberTopupIds[$i] );

                if( $memberTopup->status == 0 ){

                    $memberTopup->status = 1;
                    $memberTopup->remark = $request->remark;
                    $memberTopup->save();

                    $memberWallet = MemberWallet::where( 'user_id', $memberTopup->user_id )->where( 'type', $memberTopup->wallet_type )->first();

                    self::transact( $memberWallet, [
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                        'amount' => $memberTopup->amount,
                        'remark' => '##{topup}##',
                        'trx_type' => 1,
                    ] );

                }

            }

            \DB::commit();

        } catch ( \Throwable $th ) {
            \DB::rollBack();
            abort( 500, $th->getMessage() . ' in line: ' . $th->getLine() );
        }
    }

    public function updateRejectTopup( $request ) {

        $request->validate( [
            'remark' => 'required|string',
        ] );

        \DB::beginTransaction();

        try {

            $memberTopupIds = ( Str::contains($request->ids, ',') ? explode( ',', $request->ids ) : explode( ' ', $request->ids ) );

            for ( $i = 0; $i < count( $memberTopupIds ); $i++ ) {

                $memberTopup = MemberTopup::lockForUpdate()->find( $memberTopupIds[$i] );

                if( $memberTopup->status == 0 ){

                    $memberTopup->status = 9;
                    $memberTopup->remark = $request->remark;
                    $memberTopup->save();

                }

            }

            \DB::commit();

        } catch ( \Throwable $th ) {
            \DB::rollBack();
            abort( 500, $th->getMessage() . ' in line: ' . $th->getLine() );
        }
    }

    public function allMemberWithdrawals( $request, $export ) {

        $filter = false;

        $withdrawal = TrxRequest::with( 'user' )->select( 'trx_requests.*' );
        $withdrawal->leftJoin( 'users', 'users.id', '=', 'trx_requests.user_id' );

        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $withdrawal->whereBetween( 'trx_requests.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $withdrawal->whereBetween( 'trx_requests.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->username ) ) {
            $withdrawal->where( 'users.name', $request->username );
            $filter = true;
        }

        if ( !empty( $request->wallet_type ) ) {
            $withdrawal->where( 'trx_requests.wallet_type', $request->wallet_type );
            $filter = true;
        }

        if ( !empty( $request->status ) ) {
            $withdrawal->where( 'trx_requests.status', $request->status );
            $filter = true;
        }

        if ( $request->input( 'order.0.column' ) != 0 ) {

            switch ( $request->input( 'order.0.column' ) ) {
                case 2:
                    $withdrawal->orderBy( 'trx_requests.created_at', $request->input( 'order.0.dir' ) );
                    break;
                case 11:
                    $withdrawal->orderBy( 'trx_requests.status', $request->input( 'order.0.dir' ) );
                    break;
            }
        }

        if ( $export == false ) {

            $withdrawalCount = $withdrawal->count();

            $limit = $request->input( 'length' );
            $offset = $request->input( 'start' );

            $withdrawalObject = $withdrawal->skip( $offset )->take( $limit );
            $withdrawals = $withdrawalObject->get();

            $pageTotalAmount1 = 0;
            $pageTotalAmount2 = 0;
            $pageTotalAmount3 = 0;
            foreach ( $withdrawals->toArray() as $mt ) {
                $pageTotalAmount1 += $mt['original_amount'];
                $pageTotalAmount2 += $mt['original_process_fee'];
                $pageTotalAmount3 += ( $mt['original_amount'] - $mt['original_process_fee'] );
            }

            $withdrawal = TrxRequest::select(
                \DB::raw( 'COUNT(trx_requests.id) as total,
                SUM(original_amount) as grandTotal1,
                SUM(original_process_fee) as grandTotal2,
                SUM(original_amount-original_process_fee) as grandTotal3'
            ) );
            $withdrawal->leftJoin( 'users', 'users.id', '=', 'trx_requests.user_id' );

            if ( !empty( $request->created_date ) ) {
                if ( str_contains( $request->created_date, 'to' ) ) {
                    $dates = explode( ' to ', $request->created_date );
                    $withdrawal->whereBetween( 'trx_requests.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
                } else {
                    $withdrawal->whereBetween( 'trx_requests.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
                }
                $filter = true;
            }
    
            if ( !empty( $request->username ) ) {
                $withdrawal->where( 'users.name', $request->username );
                $filter = true;
            }
    
            if ( !empty( $request->status ) ) {
                $withdrawal->where( 'trx_requests.status', $request->status );
                $filter = true;
            }

            $withdrawal = $withdrawal->first();
            
            $data = [
                'withdrawals' => $withdrawals->each( function( $query ) {
                    $query->append( 'original_actual_amount' );
                } ),
                'draw' => $request->draw,
                'recordsFiltered' => $filter ? $withdrawalCount : $withdrawal->total,
                'recordsTotal' => TrxRequest::select( \DB::raw( 'COUNT(id) as total' ) )->first()->total,
                'subTotal' => [
                    Helper::currencyFormat( $pageTotalAmount1, 4 ),
                    Helper::currencyFormat( $pageTotalAmount2, 4 ),
                    Helper::currencyFormat( $pageTotalAmount3, 4 ),
                ],
                'grandTotal' => [
                    Helper::currencyFormat( $withdrawal->grandTotal1, 4 ),
                    Helper::currencyFormat( $withdrawal->grandTotal2, 4 ),
                    Helper::currencyFormat( $withdrawal->grandTotal3, 4 ),
                ],
            ];

            return $data;
        } else {
            return $withdrawal->get();
        }
    }

    public function updateApproveWithdrawal( $request ) {

        $request->validate( [
            'remark' => 'required|string',
        ] );

        \DB::beginTransaction();

        try {

            $withdrawalIds = ( Str::contains($request->ids, ',') ? explode( ',', $request->ids ) : explode( ' ', $request->ids ) );

            for ( $i = 0; $i < count( $withdrawalIds ); $i++ ) {

                $updateWithdrawal = TrxRequest::lockForUpdate()->find( $withdrawalIds[$i] );

                if( $updateWithdrawal->status == 0 ){

                    $updateWithdrawal->status = 1;
                    $updateWithdrawal->remark = $request->remark;
                    $updateWithdrawal->save();
                }
            }

            \DB::commit();

        } catch ( \Throwable $th ) {
            \DB::rollBack();
            abort( 500, $th->getMessage() . ' in line: ' . $th->getLine() );
        }
    }

    public function updateRejectWithdrawal( $request ) {

        $request->validate( [
            'remark' => 'required|string',
        ] );

        \DB::beginTransaction();

        try {

            $withdrawalIds = ( Str::contains($request->ids, ',') ? explode( ',', $request->ids ) : explode( ' ', $request->ids ) );

            for ( $i = 0; $i < count( $withdrawalIds ); $i++ ) {

                $updateWithdrawal = TrxRequest::lockForUpdate()->find( $withdrawalIds[$i] );

                if( $updateWithdrawal->status == 0 ){

                    $updateWithdrawal->status = 9;
                    $updateWithdrawal->remark = $request->remark;
                    $updateWithdrawal->save();

                    $memberWallet = MemberWallet::lockForUpdate()->where( 'user_id', $updateWithdrawal->user_id )->where( 'type', $updateWithdrawal->wallet_type )->first();

                    self::transact( $memberWallet, [
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                        'amount' => $updateWithdrawal->original_amount,
                        'remark' => '##{refund_withdraw}##',
                        'trx_type' => 3,
                    ] );
                }

            }

            \DB::commit();

        } catch ( \Throwable $th ) {
            \DB::rollBack();
            abort( 500, $th->getMessage() . ' in line: ' . $th->getLine() );
        }
    }

    // Member Site

    public function memberTopup($request)
    {
        $validator = \Validator::make( $request->all(), [
            'amount' => [ 'required','numeric','min:100', new CheckMathModuloRule(10)],
            'attachment'=>'required|mimes:png,jpg,jpeg',
            'security_pin' => [ 'required', new CheckSecurityPinRule ],
        ] );
        
        \Session::flash( 'title',  __('member.topup_wallet')  );

        if ( $validator->fails() ) {
            return redirect()->route( 'member.topup' )->withErrors( $validator->errors() )->withInput();
        }

        \DB::beginTransaction();

        try {
            
            $checkExist = MemberTopup::where('user_id',auth()->user()->id)->where('status',0)->count();
            if($checkExist>0)
            {
                return redirect()->route( 'member.topup' )->withErrors( __('member.error_pending_topup_request') )->withInput();
            }
            $attachment = '';
            if( $request->hasFile('attachment') ) {
                $filePaths1 = [
                    'attachment' => $request->file('attachment')->hashName(),
                ];
                $attachment = $request->file('attachment');
                foreach ($filePaths1 as $documentType => $filePath) {
    
                    $folderName = Helper::uploadCloudFolderName().'/topup';
                    Storage::disk('s3')->put($folderName.'/'.$filePath,file_get_contents($attachment),'public');
    
                    $attachment = $folderName.'/'.$filePath;
                }
            }
            $createMemberTopup = MemberTopup::create( [
                'user_id' => auth()->user()->id,
                'type'=>1,
                'wallet_type'=>1,
                'payment_method'=>1,
                'amount' => $request->amount,
                'currency_rate' => 1,
                'convert_amount' => $request->amount,
                'remark' =>'',
                'attachment' => $attachment,
                'status' => 0,//pending
            ] );
            \DB::commit();

            \Session::flash( 'success', __( 'member.member_updated' ) );
            return redirect()->route( 'member.topup' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();

            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }

    public function memberWithdraw($request)
    {
        $validator = \Validator::make( $request->all(), [
            'amount' => [ 'required','numeric','min:10', new CheckMathModuloRule(10)],
            'security_pin' => [ 'required', new CheckSecurityPinRule ],
        ] );
        
        \Session::flash( 'title',  __('member.withdraw_wallet')  );

        if ( $validator->fails() ) {
            return redirect()->route( 'member.withdraw' )->withErrors( $validator->errors() )->withInput();
        }

        \DB::beginTransaction();

        try {
            
            $checkExist = TrxRequest::where('user_id',auth()->user()->id)->where('status',0)->count();
            if($checkExist>0)
            {
                return redirect()->route( 'member.withdraw' )->withErrors( __('member.error_pending_withdraw_request') )->withInput();
            }
            if(auth()->user()->details->withdrawal_usdt_address=='')
            {
                return redirect()->route( 'member.withdraw' )->withErrors( __('member.error_update_usdt_address_before_withdraw') )->withInput();
            }
            $memberWallet = MemberWallet::lockForUpdate()->where( 'user_id',auth()->user()->id )->where('type',2)->first();
            if($memberWallet->balance < $request->amount){
                return redirect()->route( 'member.withdraw' )->withErrors( __('member.insufficient_balance') )->withInput();
            }
            $withdraw_percent = SysSetting::where('key','WITHDRAW_PERCENT')->where('status',1)->first()->value;

            $createMemberWithdraw = TrxRequest::create( [
                'user_id' => auth()->user()->id,
                'wallet_type'=>2,
                'withdraw_method'=>1,
                'member_bank_detail'=>auth()->user()->details->withdrawal_usdt_address,
                'original_amount' => $request->amount,
                'original_process_fee' => $request->amount * ($withdraw_percent/100),
                'currency_rate' => 1,
                'convert_amount' =>  $request->amount,
                'convert_process_fee'=>$request->amount * ($withdraw_percent/100),
                'remark' =>'',
                'status' => 0,//pending
            ] );

            self::transact( $memberWallet, [
                'amount' => $request->amount * -1,
                'remark' => '##{withdraw}##',
                'trx_type' =>2,
            ] );

            \DB::commit();

            \Session::flash( 'success', __( 'member.member_updated' ) );
            return redirect()->route( 'member.withdraw' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();

            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }

    public function getMemberStatements( $request ) {

        $data['transactions'] = MemberWalletTransaction::with( [ 'user' ] )
            ->select( 'member_wallet_transactions.*' )
            ->where( 'user_id', auth()->user()->id )
            ->where( 'type', $request->wallet_type ? $request->wallet_type : 1 )
            ->when( request()->start_date, function( $query ) {
                $query->where( 'created_at', '>=', request( 'start_date' ) . ' 00:00:00' );
            } )
            ->when( request()->end_date, function( $query ) {
                $query->where( 'created_at', '<=', request( 'end_date' ) . ' 23:59:59' );
            } )
            ->orderBy( 'created_at', 'DESC' )
            ->get();

        $data['recordsTotal'] = count( $data['transactions'] );

        return $data;
    }

    public function getMemberTopup( $request ) {

        $data['member_topups'] = MemberTopup::with( [ 'user' ] )
            ->select( 'member_topups.*' )
            ->where( 'user_id', auth()->user()->id )
            ->when( request()->start_date, function( $query ) {
                $query->where( 'created_at', '>=', request( 'start_date' ) . ' 00:00:00' );
            } )
            ->when( request()->end_date, function( $query ) {
                $query->where( 'created_at', '<=', request( 'end_date' ) . ' 23:59:59' );
            } )
            ->orderBy( 'created_at', 'DESC' )
            ->get();

        $data['recordsTotal'] = count( $data['member_topups'] );

        return $data;
    }

    public function getMemberWithdraw( $request ) {

        $data['withdraws'] = TrxRequest::with( [ 'user' ] )
            ->select( 'trx_requests.*' )
            ->where( 'user_id', auth()->user()->id )
            ->when( request()->start_date, function( $query ) {
                $query->where( 'created_at', '>=', request( 'start_date' ) . ' 00:00:00' );
            } )
            ->when( request()->end_date, function( $query ) {
                $query->where( 'created_at', '<=', request( 'end_date' ) . ' 23:59:59' );
            } )
            ->orderBy( 'created_at', 'DESC' )
            ->get();

        $data['recordsTotal'] = count( $data['withdraws'] );

        return $data;
    }

    public function transact( MemberWallet $memberWallet, $data ) {

        $openingBalance = $memberWallet->balance;

        $memberWallet->balance += $data['amount'];
        $memberWallet->save();

        $createMemberWalletTransaction = MemberWalletTransaction::create( [
            'member_wallet_id' => $memberWallet->id,
            'user_id' => $memberWallet->user_id,
            'created_by' => isset( $data['created_by'] ) ? $data['created_by'] : null,
            'updated_by' => isset( $data['updated_by'] ) ? $data['updated_by'] : null,
            'amount' => $data['amount'],
            'opening_balance' => $openingBalance,
            'closing_balance' => $memberWallet->balance,
            'remark' => $data['remark'],
            'type' => $memberWallet->type,
            'trx_type' => $data['trx_type'],
            'status' => 1,
        ] );
    }
}