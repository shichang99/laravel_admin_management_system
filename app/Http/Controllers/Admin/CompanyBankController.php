<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\{
    CompanyBankService,
};

use App\Models\{
    CompanyBank,
};

class CompanyBankController extends Controller
{
    public function index() {
        
        $this->data['header']['title'] = __( 'template.company_banks' );
        $this->data['content'] = 'admin.company_bank.index';

        return view( 'admin.main' )->with( $this->data );
    }

    public function create() {

        $this->data['header']['title'] = __( 'company_bank.company_bank_create' );
        $this->data['content'] = 'admin.company_bank.create';
        $this->data['data']['types'] = [
            // [
            //     'title' => __( 'company_bank.bank' ),
            //     'value' => '1',
            // ],
            [
                'title' => __( 'company_bank.usdt_trc20' ),
                'value' => '2',
            ],
        ];

        return view( 'admin.main' )->with( $this->data );
    }

    public function modify( Request $request ) {

        $this->data['header']['title'] = __( 'company_bank.company_bank_edit' );
        $this->data['content'] = 'admin.company_bank.modify';
        $this->data['data']['types'] = [
            // [
            //     'title' => __( 'company_bank.bank' ),
            //     'value' => '1',
            // ],
            [
                'title' => __( 'company_bank.usdt_trc20' ),
                'value' => '2',
            ],
        ];
        $this->data['data']['is_primaries'] = [
            [
                'title' => __( 'datatables.yes' ),
                'value' => 1,
            ],
            [
                'title' => __( 'datatables.no' ),
                'value' => 0,
            ]
        ];
        $this->data['data']['company_bank'] = CompanyBank::find( \Crypt::decryptString( $request->id ) );

        return view( 'admin.main' )->with( $this->data );
    }

    public function allCompanyBanks( Request $request ) {

        return CompanyBankService::allCompanyBanks ( $request );
    }

    public function createCompanyBank( Request $request ) {

        return CompanyBankService::createCompanyBank( $request );
    }
    
    public function updateCompanyBank( Request $request ) {

        return CompanyBankService::updateCompanyBank( $request );
    }
}
