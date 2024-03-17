<?php

namespace App\Services;

use App\Models\{
    CompanyBank,
};

use Illuminate\Support\Facades\{
    Crypt,
};

class CompanyBankService {
    
    public static function allCompanyBanks( $request , $export = false ) {

        $filter = false;

        $companyBank = CompanyBank::select( 'company_banks.*' );

        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $companyBank->whereBetween( 'company_banks.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $companyBank->whereBetween( 'company_banks.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->number ) ) {
            $companyBank->where( 'company_banks.number', $request->number );
            $filter = true;
        }

        if ( $request->input( 'order.0.column' ) != 0 ) {

            switch ( $request->input( 'order.0.column' ) ) {
                case 1:
                    $companyBank->orderBy( 'company_banks.created_at', $request->input( 'order.0.dir' ) );
                    break;
                case 2:
                    $companyBank->orderBy( 'company_banks.status', $request->input( 'order.0.dir' ) );
                    break;
            }
        }

        if ( $export == false ) {

            $companyBankCount = $companyBank->count();

            $limit = $request->input( 'length' );
            $offset = $request->input( 'start' );

            $companyBankObject = $companyBank->skip( $offset )->take( $limit );
            $companyBanks = $companyBankObject->get();

            $companyBank = CompanyBank::select(
                \DB::raw( 'COUNT(company_banks.id) as total'
            ) );

            if ( !empty( $request->created_date ) ) {
                if ( str_contains( $request->created_date, 'to' ) ) {
                    $dates = explode( ' to ', $request->created_date );
                    $companyBank->whereBetween( 'company_banks.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
                } else {
                    $companyBank->whereBetween( 'company_banks.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
                }
                $filter = true;
            }
    
            if ( !empty( $request->number ) ) {
                $companyBank->where( 'company_banks.number', $request->number );
                $filter = true;
            }

            $companyBank = $companyBank->first();

            $data = [
                'companyBanks' => $companyBanks,
                'draw' => $request->draw,
                'recordsFiltered' => $filter ? $companyBankCount : $companyBank->total,
                'recordsTotal' => CompanyBank::select( \DB::raw( 'COUNT(id) as total' ) )->first()->total,
            ];

            return $data;
        }
    }

    public static function createCompanyBank(  $request) {

        $validator = \Validator::make( $request->all(), [
            'number' => 'required|unique:company_banks,number',
            'type' => 'required',
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'admin.company_bank.create' )->withErrors( $validator->errors() )->withInput();
        }

        \DB::beginTransaction();

        try {

            CompanyBank::where( 'type', $request->type )->update( [
                'is_primary' => 0,
            ] );

            $createCompanyBank = CompanyBank::create( [
                'created_by' => auth()->user()->id,
                'number' => $request->number,
                'meta_data' => null,
                'type' => $request->type,
                'status' => 1,
                'is_primary' => 1,
            ] );

            \DB::commit();

            \Session::flash( 'success', __( 'company_bank.company_bank_created' ) );
            return redirect()->route( 'admin.company_bank.list' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }

        return $createCompanyBank;
    }

    public static function updateCompanyBank( $request ) {

        $cbID = Crypt::decryptString( $request->encrypted_id );

        $validator = \Validator::make( $request->all(), [
            'type' => 'required',
            'number' => [ 'required', 'unique:company_banks,number,' . $cbID ],
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'admin.company_bank.modify', [ 'id' => $request->encrypted_id ] )->withErrors( $validator->errors() )->withInput();
        }

        \DB::beginTransaction();

        try {

            $updateCompanyBank = CompanyBank::find( $cbID );
            $updateCompanyBank->updated_by = auth()->user()->id;
            $updateCompanyBank->number = $request->number;
            $updateCompanyBank->is_primary = $request->is_primary;

            if ( $request->is_primary == 1 ) {
                CompanyBank::where( 'type', $request->type )->update( [
                    'is_primary' => 0,
                ] );
            }
            
            $updateCompanyBank->save();

            \DB::commit();
            
            \Session::flash( 'success', __( 'company_bank.company_bank_updated' ) );
            return redirect()->route( 'admin.company_bank.list' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }
}
