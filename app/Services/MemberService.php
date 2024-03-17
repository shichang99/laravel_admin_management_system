<?php

namespace App\Services;

use App\Models\{
    BonusLimit,
    User,
    MemberBonus,
    MemberDetail,
    MemberWallet,
    MemberStructure,
    MemberUpgradeRanking,
    TmpUser,
};

use Illuminate\Support\Facades\{
    Hash,
    Crypt,
};

use App\Rules\{
    CheckEmailRule,
    CheckInvitationCodeRule,
    CheckPhoneNumberRule,
    CheckPasswordRule,
    CheckSecurityPinRule,
};

class MemberService {

    // Admin Panel
    public function allMembers( $request, $export ) {

        $filter = false;

        $user = User::with( [ 'ranking', 'sponsor' ] )->select( 'users.*' );
        // $user->leftJoin( 'countries', 'countries.id', '=', 'users.country_id' );
        $user->leftJoin( 'users as sponsor', 'sponsor.id', '=', 'users.sponsor_id' );

        if ( !empty( $request->registered_date ) ) {
            if ( str_contains( $request->registered_date, 'to' ) ) {
                $dates = explode( ' to ', $request->registered_date );
                $user->whereBetween( 'users.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $user->whereBetween( 'users.created_at', [ $request->registered_date . ' 00:00:00' , $request->registered_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->username ) ) {
            $user->where( 'users.name', $request->username );
            $filter = true;
        }

        if ( !empty( $request->email ) ) {
            $user->where( 'users.email', $request->email );
            $filter = true;
        }

        if ( !empty( $request->invitation_code ) ) {
            $user->where( 'users.invitation_code', $request->invitation_code );
            $filter = true;
        }

        if ( !empty( $request->ranking ) ) {
            $user->where( 'users.ranking_id', $request->ranking );
            $filter = true;
        }

        if ( !empty( $request->sponsor ) ) {
            $user->where( 'sponsor.name', $request->sponsor );
            $filter = true;
        }

        if ( !empty( $request->status ) ) {
            $user->where( 'users.status', $request->status );
            $filter = true;
        }

        if ( $request->input( 'order.0.column' ) != 0 ) {

            switch ( $request->input( 'order.0.column' ) ) {
                case 1:
                    $user->orderBy( 'users.created_at', $request->input( 'order.0.dir' ) );
                    break;
                case 2:
                    $user->orderBy( 'users.name', $request->input( 'order.0.dir' ) );
                    break;
                case 3:
                    $user->orderBy( 'users.email', $request->input( 'order.0.dir' ) );
                    break;
                case 4:
                    $user->orderBy( 'users.invitation_code', $request->input( 'order.0.dir' ) );
                    break;
                case 5:
                    $user->orderBy( 'users.ranking_id', $request->input( 'order.0.dir' ) );
                    break;
                case 6:
                    $user->orderBy( 'users.capital', $request->input( 'order.0.dir' ) );
                    break;
                case 8:
                    $user->orderBy( 'users.status', $request->input( 'order.0.dir' ) );
                    break;
            }
        }

        if ( $export == false ) {

            $userCount = $user->count();

            $limit = $request->input( 'length' );
            $offset = $request->input( 'start' );

            $userObject = $user->skip( $offset )->take( $limit );
            $users = $userObject->get();

            $user = User::select(
                \DB::raw( 'COUNT(users.id) as total'
            ) );
            $user->leftJoin( 'users as sponsor', 'sponsor.id', '=', 'users.sponsor_id' );

            if ( !empty( $request->registered_date ) ) {
                if ( str_contains( $request->registered_date, 'to' ) ) {
                    $dates = explode( ' to ', $request->registered_date );
                    $user->whereBetween( 'users.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
                } else {
                    $user->whereBetween( 'users.created_at', [ $request->registered_date . ' 00:00:00' , $request->registered_date . ' 23:59:59' ] );
                }
                $filter = true;
            }
    
            if ( !empty( $request->username ) ) {
                $user->where( 'users.name', $request->username );
                $filter = true;
            }

            if ( !empty( $request->email ) ) {
                $user->where( 'users.email', $request->email );
                $filter = true;
            }

            if ( !empty( $request->invitation_code ) ) {
                $user->where( 'users.invitation_code', $request->invitation_code );
                $filter = true;
            }

            if ( !empty( $request->ranking ) ) {
                $user->where( 'users.ranking_id', $request->ranking );
                $filter = true;
            }

            if ( !empty( $request->sponsor ) ) {
                $user->where( 'sponsor.name', $request->sponsor );
                $filter = true;
            }

            if ( !empty( $request->status ) ) {
                $user->where( 'users.status', $request->status );
                $filter = true;
            }

            $user = $user->first();

            $data = [
                'members' => $users,
                'draw' => $request->draw,
                'recordsFiltered' => $filter ? $userCount : $user->total,
                'recordsTotal' => User::select( \DB::raw( 'COUNT(id) as total' ) )->first()->total,
            ];

            return $data;
        } else {
            return $user->get();
        }
    }

    public function oneMember( $request ) {

        $user = User::find( $request->id );

        return response()->json( $user );
    }

    public function createMemberAdmin( $request ) {

        $validator = \Validator::make( $request->all(), [
            'username' => [ 'required', 'unique:users,name', 'alpha_dash' ],
            'fullname' => [ 'required', 'string', 'min:4' ],
            'email' => [ 'required', 'unique:users,email', new CheckEmailRule ],
            'password' => [ 'required', 'string', 'min:6' ],
            'security_pin' => [ 'required', 'numeric', 'digits:6' ],
            'country' => [ 'required', 'exists:countries,id' ],
            'phone_number' => [ 'required', new CheckPhoneNumberRule( $request->country ) ],
            'invitation_code' => [ 'required', new CheckInvitationCodeRule ],
            'ranking' => [ 'required', 'exists:rankings,id' ],
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'admin.member.register' )->withErrors( $validator->errors() )->withInput();
        }

        $createUserObject['member'] = [
            'ranking_id' => $request->ranking,
            'package_id' => 0,
            'country_id' => $request->country,
            'name' => strtolower( $request->username ),
            'email' => strtolower( $request->email ),
            'password' => Hash::make( $request->password ),
            'security_pin' => Hash::make( $request->security_pin ),
            'invitation_code' => strtoupper( \Str::random( 6 ) ),
            'status' => 1,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];

        $sponsor = User::where( 'invitation_code', $request->invitation_code )->first();

        if ( $sponsor ) {
            $createUserObject['member']['sponsor_id'] = $sponsor->id;
            $createUserObject['member']['sponsor_structure'] = $sponsor->sponsor_structure . '|' . $sponsor->id;
        } else {
            $createUserObject['member']['sponsor_id'] = null;
            $createUserObject['member']['sponsor_structure'] = '-';
        }

        $createUserObject['member_detail'] = [
            'fullname' => $request->fullname,
            'phone_number' => $request->phone_number,
        ];

        \DB::beginTransaction();

        try {

            $member = self::create( $createUserObject );

            MemberUpgradeRanking::create( [
                'created_by' => auth()->user()->id,
                'user_id' => $member->id,
                'old_ranking' => 0,
                'new_ranking' => $request->ranking,
                'is_auto' => 0,
            ] );

            \DB::commit();

            \Session::flash( 'success', __( 'member.member_created' ) );
            return redirect()->route( 'admin.member.list' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }

    public function updateMemberAdmin( $request ) {

        $userID = Crypt::decryptString( $request->encrypted_id );

        $validator = \Validator::make( $request->all(), [
            'country' => [ 'required', 'exists:countries,id' ],
            'username' => [ 'required', 'unique:users,name,' . $userID, 'alpha_dash' ],
            'email' => [ 'required', 'unique:users,email,' . $userID, new CheckEmailRule ],
            'phone_number' => [ 'required', new CheckPhoneNumberRule( $request->country, $userID ) ],
            'password' => [ 'nullable', 'string', 'min:6' ],
            'security_pin' => [ 'nullable', 'numeric', 'digits:6' ],
            'ranking' => [ 'required', 'exists:rankings,id' ],
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'admin.member.modify', [ 'id' => $request->encrypted_id ] )->withErrors( $validator->errors() )->withInput();
        }

        \DB::beginTransaction();

        try {

            $updateMember = User::find( $userID );

            $oldRanking = $updateMember->ranking_id;

            $updateMember->country_id = $request->country;
            $updateMember->ranking_id = $request->ranking;
            $updateMember->name = $request->username;
            $updateMember->email = $request->email;

            MemberUpgradeRanking::create( [
                'created_by' => auth()->user()->id,
                'user_id' => $userID,
                'old_ranking' => $oldRanking,
                'new_ranking' => $request->ranking,
                'is_auto' => 0,
            ] );

            if ( !empty( $request->password ) ) {
                $updateMember->password = $request->password;
            }
            if ( !empty( $request->security_pin ) ) {
                $updateMember->security_pin = $request->security_pin;
            }
            
            $updateMember->save();

            $updateMemberDetail = MemberDetail::where( 'user_id', $updateMember->id )->first();
            $updateMemberDetail->fullname = $request->fullname;
            $updateMemberDetail->phone_number = $request->phone_number;
            $updateMemberDetail->save();

            \DB::commit();
            
            \Session::flash( 'success', __( 'member.member_updated' ) );
            return redirect()->route( 'admin.member.list' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }

    public function updateMemberStatus( $request ) {

        $updateMember = User::find( Crypt::decryptString( $request->id ) );
        $updateMember->status = $request->status;
        $updateMember->save();

        return $updateMember;
    }

    public function memberGroup( $request ) {

        $member = User::where( 'name', $request->username )
            ->first();

        if ( !$member ) { // If invalid member username always return first user
            $member = User::first();
        }

        $user = User::with( [ 'ranking', 'package', 'sponsor.ranking' ] )->where( function( $query ) use ( $member ) {
            $query->where( 'sponsor_structure', 'LIKE', '%' . $member->sponsor_structure . '|' . $member->id . '%' );
            $query->orWhere( 'sponsor_structure', 'LIKE', '%' . $member->sponsor_structure . '|' . $member->id . '|%' );
            $query->orWhere( 'id', $member->id );
        } );

        $userCount = $user->count();

        $limit = $request->input( 'length' );
        $offset = $request->input( 'start' );

        $userObject = $user->skip( $offset )->take( $limit );

        $users = $user->get()->each( function( $query ) {
            $query->append( 'total_direct_sponsor' );
            $query->append( 'total_group' );
        } );

        $data = [
            'searchUser' => (string) $member->id,
            'members' => $users,
            'draw' => $request->draw,
            'recordsFiltered' => $userCount,
            'recordsTotal' => $userCount,
        ];

        return $data;
    }

    // Member Site
    public function getMembers() {

    }

    public function getMember() {

        $member = User::with( [ 'country', 'memberDetail' ] )->find( auth()->user()->id );

        return $member;
    }

    public function requestTAC( $request ) {

        $request->validate( [
            'country' => [ 'required', 'exists:countries,id' ],
            'username' => [ 'required', 'unique:users,name', 'alpha_dash' ],
            'email' => [ 'required', 'unique:users,email', new CheckEmailRule ],
            'phone_number' => [ 'required', new CheckPhoneNumberRule( $request->country ) ],
            'fullname' => [ 'required', 'string', 'min:4', 'alpha_dash' ],
            'password' => [ 'required', 'string', 'min:6' ],
            'security_pin' => [ 'required', 'numeric', 'digits:6' ],
            'invitation_code' => [ 'required', new CheckInvitationCodeRule ],
        ] );

        \DB::beginTransaction();

        try {

            $date = new \DateTime( date( 'Y-m-d H:i:s' ) );
            $date->add( new \DateInterval( 'PT15M' ) );

            $createTmpUser = TmpUser::create( [
                'country_id' => $request->country,
                'name' => strtolower( $request->username ),
                'email' => strtolower( $request->email ),
                'phone_number' => $request->phone_number,
                'fullname' => $request->fullname,
                'password' => Hash::make( $request->password ),
                'security_pin' => Hash::make( $request->security_pin ),
                'otp_code' => mt_rand( 100000, 999999 ),
                'status' => 'pending',
                'expire_on' => $date->format( 'Y-m-d H:i:s' ),
            ] );

            \DB::commit();
    
            // Send SMS
    
            return response()->json( [
                'status' => true,
                'tmp_user' => Crypt::encryptString( $createTmpUser->id ),
            ] );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            abort( 500, $th->getMessage() . ' in line: ' . $th->getLine() );
        }
    }

    public function resendTAC( $request ) {

        $request->validate( [
            'tmp_user' => [ 'required', function( $attribute, $value, $fail ) {
                try {
                    $current = TmpUser::find( Crypt::decryptString( $value ) );

                    if ( !$current ) {
                        $fail( __( 'api.tmp_user_invalid' ) );
                        return 0;
                    }

                    if ( $current->status != 'pending' ) {
                        $fail( __( 'api.tmp_user_invalid' ) );
                    }
                } catch ( \Throwable $th ) {
                    $fail( __( 'api.tmp_user_invalid' ) );
                }
            } ],
        ] );

        try {

            $date = new \DateTime( date( 'Y-m-d H:i:s' ) );
            $date->add( new \DateInterval( 'PT15M' ) );

            $current = TmpUser::find( Crypt::decryptString( $request->tmp_user ) );
            $current->otp_code = mt_rand( 100000, 999999 );
            $current->expire_on = $date->format( 'Y-m-d H:i:s' );
            $current->save();

            return response()->json( [
                'status' => true,
            ] );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            abort( 500, $th->getMessage() . ' in line: ' . $th->getLine() );
        }
    }
    
    public function createMember( $request ) {

        $request->validate( [
            'otp_code' => 'required',
            'tmp_user' => [ 'required', function( $attribute, $value, $fail ) {
                try {
                    $current = TmpUser::find( Crypt::decryptString( $value ) );

                    if ( $current->otp_code != request( 'otp_code' ) ) {
                        $fail( __( 'api.otp_code_invalid' ) );
                    }

                    if ( $current->status != 'pending' ) {
                        $fail( __( 'api.otp_code_invalid' ) );
                    }
                } catch ( \Throwable $th ) {
                    $fail( __( 'api.otp_code_invalid' ) );
                }
            } ],
            'country' => [ 'required', 'exists:countries,id' ],
            'username' => [ 'required', 'unique:users,name', 'alpha_dash' ],
            'email' => [ 'required', 'unique:users,email', new CheckEmailRule ],
            'phone_number' => [ 'required', new CheckPhoneNumberRule( $request->country ) ],
            'fullname' => [ 'required', 'string', 'min:4', 'alpha_dash' ],
            'password' => [ 'required', 'string', 'min:6' ],
            'security_pin' => [ 'required', 'numeric', 'digits:6' ],
            'invitation_code' => [ 'required', new CheckInvitationCodeRule ],
        ] );

        $createUserObject['member'] = [
            'country_id' => $request->country,
            'ranking_id' => 1,
            'package_id' => 0,
            'name' => strtolower( $request->username ),
            'email' => strtolower( $request->email ),
            'password' => Hash::make( $request->password ),
            'security_pin' => Hash::make( $request->security_pin ),
            'invitation_code' => strtoupper( \Str::random( 6 ) ),
            'status' => 1,
            'created_by' => 0,
            'updated_by' => 0,
        ];

        $sponsor = User::where( 'invitation_code', $request->invitation_code )->first();

        if ( $sponsor ) {
            $createUserObject['member']['sponsor_id'] = $sponsor->id;
            $createUserObject['member']['sponsor_structure'] = $sponsor->sponsor_structure . '|' . $sponsor->id;
        } else {
            $createUserObject['member']['sponsor_id'] = null;
            $createUserObject['member']['sponsor_structure'] = '-';
        }

        $createUserObject['member_detail'] = [
            'fullname' => $request->fullname,
            'phone_number' => $request->phone_number,
        ];

        \DB::beginTransaction();

        try {

            self::create( $createUserObject );

            $updateTmpUser = TmpUser::find( Crypt::decryptString( $request->tmp_user ) );
            $updateTmpUser->status = 'registered';
            $updateTmpUser->save();

            \DB::commit();

            return response()->json( [
                'status' => true,
            ] );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            abort( 500, $th->getMessage() . ' in line: ' . $th->getLine() );
        }
    }

    public function updateMember( $request ) {

        $validator = \Validator::make( $request->all(), [
            'country' => [ 'required', 'exists:countries,id' ],
            'email' => [ 'required', 'unique:users,email,'.auth()->user()->id, new CheckEmailRule ],
            'phone_number' => [ 'required', new CheckPhoneNumberRule( $request->country, auth()->user()->id ) ],
        ] );

        \Session::flash( 'title',  __('member.edit_title',['title' => __('member.profile')])  );

        if ( $validator->fails() ) {
            return redirect()->route( 'member.edit_profile' )->withErrors( $validator->errors() )->withInput();
        }

        \DB::beginTransaction();

        try {

            $updateMember = User::find( auth()->user()->id );
            $updateMember->country_id = $request->country;
            $updateMember->email = $request->email;

            $updateMemberDetail = MemberDetail::where( 'user_id', $updateMember->id )->first();
            $updateMemberDetail->phone_number = $request->phone_number;
            $updateMemberDetail->save();

            \DB::commit();

            \Session::flash( 'success', __( 'member.member_updated' ) );
            return redirect()->route( 'member.edit_profile' );
            
        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }

    public function updatePassword( $request ) {

        $validator = \Validator::make( $request->all(), [
            'old_password' => [ 'required', 'min:6', new CheckPasswordRule ],
            'password' => [ 'required', 'confirmed' ],
        ] );
        
        \Session::flash( 'title',  __('member.edit_title',['title' => __('member.password')])  );

        if ( $validator->fails() ) {
            \Session::flash( 'tab', 'password' );
            return redirect()->route( 'member.security_center' )->withErrors( $validator->errors() )->withInput();
        }

        \DB::beginTransaction();

        try {
            
            $updateMember = User::find( auth()->user()->id );
            $updateMember->password = Hash::make( $request->password );
            $updateMember->save();

            \DB::commit();
            \Session::flash( 'tab', 'password' );
            \Session::flash( 'success', __( 'member.member_updated' ) );
            return redirect()->route( 'member.security_center' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'tab', 'password' );
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }
    
    public function updateSecurityPin( $request ) {

        $validator = \Validator::make( $request->all(), [
            'old_security_pin' => [ 'required', 'numeric', 'digits:6', new CheckSecurityPinRule ],
            'security_pin' => [ 'required', 'numeric', 'digits:6', 'confirmed' ],
        ] );

        \Session::flash( 'title',  __('member.edit_title',['title' => __('member.security_pin')]) );

        if ( $validator->fails() ) {
            \Session::flash( 'tab', 'security_pin' );
            return redirect()->route( 'member.security_center' )->withErrors( $validator->errors() )->withInput();
        }

        \DB::beginTransaction();

        try {

            $updateMember = User::find( auth()->user()->id );
            $updateMember->security_pin = Hash::make( $request->security_pin );
            $updateMember->save();

            \DB::commit();
            
            \Session::flash( 'tab', 'security_pin' );
            \Session::flash( 'success', __( 'member.member_updated' ) );
            return redirect()->route( 'member.security_center' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'tab', 'security_pin' );
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }

    // Share
    public function create( $data ) {

        $createMember = User::create( $data['member'] );

        $data['member_detail']['user_id'] = $createMember->id;

        $createMemberDetail = MemberDetail::create( $data['member_detail'] );

        for ( $i = 1; $i <= 1; $i++ ) { 
            MemberWallet::create( [
                'user_id' => $createMember->id,
                'type' => $i,
                'balance' => 0,
            ] );    
        }

        if ( $data['member']['sponsor_id'] ) {
            $sponsorArray = explode( '|', $data['member']['sponsor_structure'] );
            $sponsorLevel = count( $sponsorArray );
            for ( $i = $sponsorLevel - 1; $i >= 0; $i-- ) {
                if ( $sponsorArray[$i] != '-' ) {
                    MemberStructure::create( [
                        'user_id' => $createMember->id,
                        'sponsor_id' => $sponsorArray[$i],
                        'level' => $sponsorLevel - $i
                    ] );
                }
            }
        }

        MemberBonus::create( [
            'user_id' => $createMember->id,
            'balance' => 0,
        ] );

        BonusLimit::create( [
            'user_id' => $createMember->id,
            'balance' => 0,
        ] );

        return $createMember;
    }

    public function announcementRead( $request ) {

        $latestAnnouncemet = Announcement::where( 'status', 1 )->where( 'type', 1 )->orderByDesc( 'id' )->first();

        MemberAnnouncementRead::firstOrCreate( [
            'announcement_id' => $latestAnnouncemet->id,
            'user_id' => auth()->user()->id,
        ], [
            'announcement_id' => $latestAnnouncemet->id,
            'user_id' => auth()->user()->id,
        ] );
    }

    public function updateMemberCapital( $id, $capital ) {

        $updateCapital = User::lockForUpdate()->find( $id );
        $updateCapital->capital += $capital;
        $updateCapital->save();
    }

    public function checkRankingQualify( $member ) {

        if ( !$member->sponsor_id ) {
            return true;
        }

        $sponsorStructure = explode( '|', $member->sponsor_structure . '|' . $member->id );
        $sponsorLevel = count( $sponsorStructure );

        for ( $i = $sponsorLevel - 1; $i >= 0; $i-- ) {

            if ( $sponsorStructure[$i] != '-' ) {

                $upline = User::find( $sponsorStructure[$i] );
                if ( $upline->capital < 100 ) {
                    continue;
                }

                $groupList = MemberStructure::where( 'sponsor_id', $upline->id )->get()->pluck( 'user_id' )->toArray();
                $groupSale = User::where( 'status', 1 )->whereIn( 'id', $groupList )->sum( 'capital' );

                $sponsorCount = User::where( 'status', 1 )->where( 'sponsor_id', $upline->id )->count();

                $allowUpdate = 0;
                $rankings = Ranking::where( 'min_capital', '<=', $upline->capital )
                    ->where( 'min_sponsor', '<=', $sponsorCount )
                    ->where( 'min_group', '<=', $groupSale )
                    ->orderBy( 'id', 'DESC' )
                    ->get();

                $ranking = [];
                foreach ( $rankings as $r ) {

                    $directSponsor = User::where( 'status', 1 )->where( 'ranking_id', $r->sponsor_ranking )->count();
                    if ( $directSponsor >= $r->sponsor_ranking_count ) {
                        $ranking = $r;
                        break;
                    }
                }

                if ( !$ranking ) {
                    continue;
                }

                if ( $ranking->id > $upline->ranking_id ) {
                    $allowUpdate = 1;
                }

                if ( $allowUpdate ) {

                    MemberUpgradeRanking::create( [
                        'user_id' => $upline->id,
                        'old_ranking' => $upline->ranking_id,
                        'new_ranking' => $ranking->id,
                        'is_auto' => 1,
                    ] );

                    $upline->ranking_id = $ranking->id;
                    $upline->save();
                }
            }
        }

        return true;
    }
}