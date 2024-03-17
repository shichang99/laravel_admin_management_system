<?php

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

use App\Http\Controllers\Admin\{
    AdministratorController,
    AnnouncementController,
    CompanyBankController,
    DashboardController,
    MemberController,
    WalletController,
    SettingController,
    MaintenanceController,
};

Route::prefix( 'bol' )->group( function() {

    Route::get( '/', function() {
        return redirect()->route( 'admin.dashboard' );
    } );
    
    Route::middleware( [ 'auth:admin', 'forceRedirectToMember' ] )->group( function() {

        Route::prefix( 'announcements' )->group( function() {

            Route::group( [ 'middleware' => [ 'permission:add announcements|view announcements|edit announcements|delete announcements' ] ], function() {
                Route::get( '/', [ AnnouncementController::class, 'index' ] )->name( 'admin.announcement.list' );
                Route::get( 'create', [ AnnouncementController::class, 'create' ] )->name( 'admin.announcement.create' );
                Route::get( 'modify', [ AnnouncementController::class, 'modify' ] )->name( 'admin.announcement.modify' );
                Route::post( 'update-announcement-status', [ AnnouncementController::class, 'updateAnnouncementStatus' ] );
                Route::post( 'update-announcement', [ AnnouncementController::class, 'updateAnnouncement' ] )->name( 'admin.announcement.update' );
            } );

            Route::post( 'create', [ AnnouncementController::class, 'createAnnouncement' ] )->name( 'admin.announcement.create' );

            Route::post( 'all-announcements', [ AnnouncementController::class, 'allAnnouncements' ] );
            Route::post( 'one-announcement', [ AnnouncementController::class, 'oneAnnouncement' ] );

            Route::post( 'lang', [ AnnouncementController::class, 'announcementLang' ] )->name( 'admin.announcement.lang' );
        } );

        Route::prefix( 'administrators' )->group( function() {

            Route::group( [ 'middleware' => [ 'permission:add admins|view admins|edit admins|delete admins' ] ], function() {
                Route::get( '/', [ AdministratorController::class, 'index' ] )->name( 'admin.admin.list' );
                Route::get( 'admin-logs', [ AdministratorController::class, 'adminLog' ] )->name( 'admin.admin.admin_log' );
            } );

            Route::post( 'all-admins', [ AdministratorController::class, 'allAdmins' ] );
            Route::post( 'one-admin', [ AdministratorController::class, 'oneAdmin' ] );
            Route::post( 'create-admin', [ AdministratorController::class, 'createAdmin' ] );
            Route::post( 'update-admin', [ AdministratorController::class, 'updateAdmin' ] );
            Route::post( 'update-admin-status', [ AdministratorController::class, 'updateAdminStatus' ] );

            Route::post( 'admin-logs', [ AdministratorController::class, 'allAdminLogs' ] );
        } );
    
        Route::prefix( 'dashboard' )->group( function() {
            Route::get( '/', [ DashboardController::class, 'index' ] )->name( 'admin.dashboard' );
        } );
    
        Route::prefix( 'members' )->group( function() {

            Route::group( [ 'middleware' => [ 'permission:add members|view members|edit members|delete members' ] ], function() {
                Route::get( '/', [ MemberController::class, 'index' ] )->name( 'admin.member.list' );
                Route::get( 'register', [ MemberController::class, 'register' ] )->name( 'admin.member.register' );
                Route::get( 'modify', [ MemberController::class, 'modify' ] )->name( 'admin.member.modify' );
                Route::get( 'groups', [ MemberController::class, 'group' ] )->name( 'admin.member.group' );

                Route::get( 'export', [ MemberController::class, 'exportMember' ] )->name( 'admin.member.export' );
            } );

            Route::post( 'create', [ MemberController::class, 'createMember' ] )->name( 'admin.member.create' );
            Route::post( 'update', [ MemberController::class, 'updateMember' ] )->name( 'admin.member.update' );

            Route::post( 'all-members', [ MemberController::class, 'allMembers' ] );
            Route::post( 'one-member', [ MemberController::class, 'oneMember' ] );
            Route::post( 'create-member', [ MemberController::class, 'createMember' ] );
            Route::post( 'update-member', [ MemberController::class, 'updateMember' ] );
            Route::post( 'update-member-status', [ MemberController::class, 'updateMemberStatus' ] );

            Route::get( 'login', [ MemberController::class, 'loginMember' ] )->name( 'admin.member.login' );

            Route::post( 'groups', [ MemberController::class, 'memberGroup' ] );
        } );

        Route::prefix( 'wallets' )->group( function() {

            Route::group( [ 'middleware' => [ 'permission:add wallets|view wallets|edit wallets|delete wallets' ] ], function() {
                Route::get( '/', [ WalletController::class, 'index' ] );
                Route::get( 'statements', [ WalletController::class, 'statement' ] );
            } );

            Route::post( 'all-member-wallets', [ WalletController::class, 'allMemberWallets' ] );
            Route::post( 'one-member-wallet', [ WalletController::class, 'oneMemberWallet' ] );
            Route::post( 'update-member-wallet', [ WalletController::class, 'updateMemberWallet' ] );

            Route::post( 'all-member-statements', [ WalletController::class, 'allMemberStatements' ] );

            Route::get( 'export_wallet_list', [ WalletController::class, 'exportWalletListing' ] )->name( 'admin.wallets.export_wallet_list' );
            Route::get( 'export_statement_list', [ WalletController::class, 'exportWalletStatement' ] )->name( 'admin.wallets.export_statement_list' );
        } );

        Route::prefix( 'topups' )->group( function() {

            Route::group( [ 'middleware' => [ 'permission:add topups|view topups|edit topups|delete topups' ] ], function() {
                Route::get( '/', [ WalletController::class, 'topup' ] );
            } );

            Route::post( 'all-member-topups', [ WalletController::class, 'allMemberTopups' ] );
            Route::post( 'update-approve-topup', [ WalletController::class, 'updateApproveTopup' ] );
            Route::post( 'update-reject-topup', [ WalletController::class, 'updateRejectTopup' ] );

            Route::get( 'export_topup_list', [ WalletController::class, 'exportWalletTopups' ] )->name( 'admin.wallets.export_topup_list' );
        } );

        Route::prefix( 'withdrawals' )->group( function() {

            Route::group( [ 'middleware' => [ 'permission:add withdrawals|view withdrawals|edit withdrawals|delete withdrawals' ] ], function() {
                Route::get( '/', [ WalletController::class, 'withdrawal' ] );
            } );

            Route::post( 'all-member-withdrawals', [ WalletController::class, 'allMemberWithdrawals' ] );
            Route::post( 'update-approve-withdrawal', [ WalletController::class, 'updateApproveWithdrawal' ] );
            Route::post( 'update-reject-withdrawal', [ WalletController::class, 'updateRejectWithdrawal' ] );

            Route::get( 'export_withdrawal_list', [ WalletController::class, 'exportWalletWithdrawals' ] )->name( 'admin.wallets.export_withdrawal_list' );
        } );

        Route::prefix( 'company-banks' )->group( function() {

            Route::group( [ 'middleware' => [ 'permission:add company_banks|view company_banks|edit company_banks|delete company_banks' ] ], function() {
                Route::get( '/', [ CompanyBankController::class, 'index' ] )->name( 'admin.company_bank.list' );
                Route::get( 'create', [ CompanyBankController::class, 'create' ] )->name( 'admin.company_bank.create' );
                Route::get( 'modify', [ CompanyBankController::class, 'modify' ] )->name( 'admin.company_bank.modify' );
            } );

            Route::post( 'all-company-banks', [ CompanyBankController::class, 'allCompanyBanks' ] );
            Route::post( 'one-company-bank', [ CompanyBankController::class, 'oneCompanyBank' ] );
            Route::post( 'create-company-bank', [ CompanyBankController::class, 'createCompanyBank' ] )->name( 'admin.company_bank.create_' );
            Route::post( 'update-company-bank', [ CompanyBankController::class, 'updateCompanyBank' ] )->name( 'admin.company_bank.update' );
        } );

        Route::prefix( 'settings' )->group( function() {

            Route::group( [ 'middleware' => [ 'permission:add settings|view settings|edit settings|delete settings' ] ], function() {
                Route::get( '/', [ SettingController::class, 'index' ] );
            } );

            Route::post( 'all-settings', [ SettingController::class, 'allSettings' ] );
            Route::post( 'one-setting', [ SettingController::class, 'oneSetting' ] );
            Route::post( 'create-setting', [ SettingController::class, 'createSetting' ] );
            Route::post( 'update-setting', [ SettingController::class, 'updateSetting' ] );
        } );
        Route::prefix( 'maintenances' )->group( function() {

            Route::group( [ 'middleware' => [ 'permission:add maintenances|view maintenances|edit maintenances|delete maintenances' ] ], function() {
                Route::get( '/', [ MaintenanceController::class, 'index' ] )->name( 'admin.maintenance.list' );
                Route::get( 'create', [ MaintenanceController::class, 'create' ] )->name( 'admin.maintenance.create' );
                Route::get( 'modify', [ MaintenanceController::class, 'modify' ] )->name( 'admin.maintenance.modify' );
            } );

            Route::post( 'all-maintenances', [ MaintenanceController::class, 'allMaintenances' ] );
            Route::post( 'one-maintenance', [ MaintenanceController::class, 'oneMaintenance' ] );
            Route::post( 'update-maintenance-status', [ MaintenanceController::class, 'updateMaintenanceStatus' ] );
            Route::post( 'create-maintenance', [ MaintenanceController::class, 'createMaintenance' ] )->name( 'admin.maintenance.create_' );
            Route::post( 'update-maintenance', [ MaintenanceController::class, 'updateMaintenance' ] )->name( 'admin.maintenance.update' );

        } );


    } );
    
    Route::get( 'lang/{lang}', function( $lang ) {

        if ( array_key_exists( $lang, Config::get( 'languages' ) ) ) {
            Session::put( 'appLocale', $lang );
        }
        
        return Redirect::back();
    } );

    Route::get( 'login', function() {

        $data['basic'] = true;
        $data['content'] = 'admin.auth.login';

        return view( 'admin.main_pre_auth' )->with( $data );

    } )->middleware( 'guest:admin' )->name( 'admin.login' );

    $limiter = config( 'fortify.limiters.login' );

    Route::post( 'login', [ AuthenticatedSessionController::class, 'store' ] )->middleware( array_filter( [ 'guest:admin', $limiter ? 'throttle:'.$limiter : null ] ) );

    Route::post( 'logout', [ AuthenticatedSessionController::class, 'destroy' ] )->middleware( 'auth:admin' )->name( 'admin.logout' );
} );