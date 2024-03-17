<?php

namespace App\Helpers;

class Helper {

    public static function uploadCloudFolderName() {
        return __( 'ms.s3_folder' );
    }

    public static function websiteName() {
        return __( 'ms.website_name' );
    }

    public static function baseUrl() {
        return url( '/' );
    }

    public static function baseAdminUrl() {
        return url( '/' ) . '/' . self::adminPath();
    }

    public static function adminPath() {
        return 'bol';
    }

    public static function assetVersion() {
        return '?v=1.01';
    }

    public static function moduleActions() {

        return [
            'add',
            'view',
            'edit',
            'delete'
        ];
    }

    public static function columnIndex( $object, $search ) {
        foreach ( $object as $key => $o ) {
            if ( $o['id'] == $search ) {
                return $key;
                break;
            }
        }
    }

    public static function wallets() {

        return [
            [ 'key' => 1, 'value' => 1, 'title' => __( 'wallet.wallet_1' ) ],
            [ 'key' => 2, 'value' => 2, 'title' => __( 'wallet.wallet_2' ) ],
        ];
    }

    public static function walletName() {

        return [
            '1' => __( 'wallet.wallet_1' ),
            '2' => __( 'wallet.wallet_2' ),
            '3' => __( 'wallet.wallet_3' ),
        ];
    }

    public static function trxtype() {

        return [
            [ 'key' => 1, 'value' => 1, 'title' => __( 'wallet.topup' ) ],
            [ 'key' => 2, 'value' => 2, 'title' => __( 'wallet.withdraw' ) ],
            [ 'key' => 3, 'value' => 3, 'title' => __( 'wallet.refund_withdraw' ) ],
            [ 'key' => 9, 'value' => 9, 'title' => __( 'wallet.manual_topup_deduct' ) ],
        ];
    }

    public static function trxtypeName() {

        return [
            '1' => __( 'wallet.topup' ),
            '2' => __( 'wallet.withdraw' ),
            '3' => __( 'wallet.refund_withdraw' ),
            '4' => __( 'wallet.convert_to' ),
            '5' => __( 'wallet.convert_from' ),
            '6' => __( 'wallet.transfer_to' ),
            '7' => __( 'wallet.transfer_from' ),
            '8' => __( 'wallet.investment' ),
            '9' => __( 'wallet.manual_topup_deduct' ),
            '10' => __( 'wallet.refund_investment' ),
            '20' => __( 'wallet.roi_bonus' ),
            '21' => __( 'wallet.generation_bonus' ),
        ];
    }

    public static function currencyFormat( $number, $decimal, $isRound = false ) {
        if( $isRound ) {
            return number_format( $number, $decimal );    
        } else {
            return number_format( bcdiv( $number, 1, $decimal ), $decimal );
        }
    }

    public static function walletInfo() {

        $wallets = MemberWallet::where( 'user_id', auth()->user()->id )->get();

        $walletInfo = [];

        foreach ( $wallets as $wallet ) {
            $walletInfo[$wallet->type] = $wallet->balance;
        }

        return $walletInfo;
    }

    public static function translateDate( $date ) {

        $dateTimestamp = strtotime( $date );

        if( \App::getLocale() == 'zh' ) {
            return date( 'Y' ) . __( 'template.year' ) . date( 'n' ) . __( 'template.month' ) . date( 'j' ) . __( 'template.day' ) . ' ' . date( 'H:i:s' );
        } else {
            return date( 'd M Y H:i:s', $dateTimestamp );
        }
    }

    public static function curlGet( $endpoint, $header = [] ) {

        $curl = curl_init();

        curl_setopt_array( $curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
        ) );

        $response = curl_exec ($curl );
        $error = curl_error( $curl );
        
        curl_close( $curl );

        if( $error ) {
            return false;
        } else {
            return $response;
        }
    }

    public static function curlPost( $endpoint, $data, $header = [
        "accept: */*",
        "accept-language: en-US,en;q=0.8",
        "content-type: application/json",
    ] ) {
        
        $curl = curl_init();
        
        curl_setopt_array( $curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $header
        ] );
        
        $response = curl_exec ($curl );
        $error = curl_error( $curl );
        
        curl_close( $curl );
        
        if( $error ) {
            return false;
        } else {
            return $response;
        }
    }

    public static function notifyTelegram( $chatID, $module, $errorMessage ) {

        $message = urlencode( env( 'APP_NAME' ) . ":\n" . strtoupper( $module ) . " => " . $errorMessage );

    }

    public static function exportReport( $html, $model ) {

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString( $html );

        foreach( $spreadsheet->getActiveSheet()->getColumnIterator() as $column ) {
            $spreadsheet->getActiveSheet()->getColumnDimension( $column->getColumnIndex() )->setAutoSize( true );
        }

        $filename = $model . '_' . date( 'ymd_His' ) . '.xlsx';

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter( $spreadsheet, 'Xlsx' );
        $writer->save( 'storage/'.$filename );

        $content = file_get_contents( 'storage/'.$filename );

        header( "Content-Disposition: attachment; filename=".$filename );
        unlink( 'storage/'.$filename );
        exit( $content );
    }
}