<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\{
    MemberService,
};

class MemberController extends Controller
{
    /*public function index() {

        // This is loading the page, located in resources/views/member/member/
        $this->data['content'] = 'member.member.index';

        // This is pass to header
        $this->data['header']['title'] = 'HOME';

        // This is pass custom data
        $this->data['data']['my_data'] = [
            'a' => 1,
            'b' => 2,
        ];

        // This is master page, located in resources/views/member
        return view( 'member.main' )->with( $this->data );
    }*/

    public function index() {
    
        $this->data['basic'] = true;
        $this->data['userInfo'] = true;
        $this->data['home'] = true;
        $this->data['bottom_nav'] = true;
        $this->data['title'] = __('ms.home');
        $this->data['templateStyle'] = "bg-02";
        $this->data['content'] = 'member.member.home';
        $this->data['sidebarBold'] = 'home';

        $this->data['data']['latest_announcement_read'] = MemberAnnouncementRead::where( 'announcement_id', $this->data['data']['latest_announcement']->id )->where( 'user_id', auth()->user()->id )->first();
        
        return view( 'member.main' )->with( $this->data );
    }
    
    public function profile()
    {
        $this->data['basic'] = true;
        $this->data['logoutBtn'] = true;
        $this->data['bottom_nav'] = true;
        $this->data['title'] = __('ms.profile');
        $this->data['templateStyle'] = "bg-02";
        $this->data['content'] = 'member.member.profile';
        $this->data['sidebarBold'] = 'profile';

        return view( 'member.main' )->with( $this->data );
    }

    public function requestTAC( Request $request ) {

        return MemberService::requestTAC( $request );
    }

    public function resendTAC( Request $request ) {

        return MemberService::resendTAC( $request );
    }

    public function signup( Request $request ) {

        return MemberService::createMember( $request );
    }
}
