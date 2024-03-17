<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\{
    MemberService,
};

use App\Models\{
    Country,
    User,
    Ranking,
};

use Helper;

class MemberController extends Controller
{
    public function index() {

        $this->data['header']['title'] = __( 'template.members' );
        $this->data['content'] = 'admin.member.index';
        $rankings = [];
        foreach( Ranking::select( 'id', 'name' )->get() as $ranking ) {
            array_push( $rankings, [ 'key' => $ranking->id, 'value' => $ranking->id, 'title' => $ranking->name ] );
        }
        $this->data['data']['rankings'] = $rankings;
        $this->data['breadcrumb'] = [
            [
                'url' => route( 'admin.dashboard' ),
                'text' => __( 'template.dashboard' ),
                'class' => '',
            ],
            [
                'url' => '',
                'text' => __( 'member.members' ),
                'class' => 'active',
            ],
        ];

        return view( 'admin.main' )->with( $this->data );
    }

    public function register() {

        $this->data['content'] = 'admin.member.register';
        $this->data['data']['countries'] = Country::select( 'id', 'country_name', 'call_code' )->get();
        $this->data['data']['rankings'] = Ranking::select( 'id', 'name' )->get();
        $this->data['breadcrumb'] = [
            [
                'url' => route( 'admin.dashboard' ),
                'text' => __( 'template.dashboard' ),
                'class' => '',
            ],
            [
                'url' => route( 'admin.member.list' ),
                'text' => __( 'template.members' ),
                'class' => '',
            ],
            [
                'url' => '',
                'text' => __( 'template.register' ),
                'class' => 'active',
            ],
        ];

        return view( 'admin.main' )->with( $this->data );
    }

    public function modify( Request $request ) {

        $this->data['content'] = 'admin.member.modify';
        $this->data['data']['countries'] = Country::select( 'id', 'country_name', 'call_code' )->get();
        $this->data['data']['user'] = User::with( [ 'memberDetail' ] )->find( \Crypt::decryptString( $request->id ) );
        $this->data['data']['rankings'] = Ranking::select( 'id', 'name' )->get();
        $this->data['breadcrumb'] = [
            [
                'url' => route( 'admin.dashboard' ),
                'text' => __( 'template.dashboard' ),
                'class' => '',
            ],
            [
                'url' => route( 'admin.member.list' ),
                'text' => __( 'template.members' ),
                'class' => '',
            ],
            [
                'url' => '',
                'text' => __( 'template.modify' ),
                'class' => 'active',
            ],
        ];

        return view( 'admin.main' )->with( $this->data );
    }

    public function group() {

        $this->data['breadcrumb'] = [
            [
                'url' => route( 'admin.dashboard' ),
                'text' => __( 'template.dashboard' ),
                'class' => '',
            ],
            [
                'url' => '',
                'text' => __( 'template.groups' ),
                'class' => 'active',
            ],
        ];
        
        $this->data['content'] = 'admin.member.group';

        return view( 'admin.main' )->with( $this->data );
    }

    public function allMembers( Request $request, $export = false ) {

        return MemberService::allMembers( $request, $export );
    }

    public function oneMember( Request $request ) {

        return MemberService::oneMember( $request );
    }

    public function createMember( Request $request ) {

        return MemberService::createMemberAdmin( $request );
    }

    public function updateMember( Request $request ) {

        return MemberService::updateMemberAdmin( $request );
    }

    public function updateMemberStatus( Request $request ) {

        return MemberService::updateMemberStatus( $request );
    }

    public function loginMember( Request $request ) {

        if( \Session::has( 'login_failed' ) ) {
            \Session::flash( 'error', 'Error while login to member account.' );
            return redirect()->route( 'admin.member.list' );
        }

        $timestamp = time();
        $key = 'hellodontplayplay';
        $secret = \Crypt::encryptString( $key . $timestamp );

        $user = User::find( \Crypt::decryptString( $request->id ) );

        $html = 
        '
        <form id="login_form" method="POST" action="' . route( 'member.login' ) . '">
        <input name="username" type="hidden" value="' . $user->name . '" />
        <input name="password" type="hidden" value="1" />
        <input name="from_admin" type="hidden" value="1" />
        <input name="secret" type="hidden" value="' . $secret . '" />
        <input name="timestamp" type="hidden" value="' . $timestamp . '" />
        <input name="_token" type="hidden" value="' . csrf_token() . '" />
        </form>
        ';
        $html .= 
        '
        <script>
        document.getElementById( "login_form" ).submit();
        </script>
        ';
        echo $html;
    }

    public function memberGroup( Request $request ) {
        
        return MemberService::memberGroup( $request );
    }

    public function exportMember( Request $request ) {

        $members = $this->allMembers( $request, true );

        $html = '<table>';
        $html .= '
        <thead>
            <tr>
                <th><strong>No.</strong></th>
                <th><strong>'.__( 'datatables.registered_date' ).'</strong></th>
                <th><strong>'.__( 'member.username' ).'</strong></th>
                <th><strong>'.__( 'member.email' ).'</strong></th>
                <th><strong>'.__( 'member.invitation_code' ).'</strong></th>
                <th><strong>'.__( 'member.ranking' ).'</strong></th>
                <th><strong>'.__( 'member.capital' ).'</strong></th>
                <th><strong>'.__( 'member.sponsor' ).'</strong></th>
                <th><strong>'.__( 'datatables.status' ).'</strong></th>
            </tr>
        </thead>
        ';
        $html .= '<tbody>';

        foreach ( $members as $key => $member ) {
            $html .=
            '
            <tr>
                <td>' . ( $key + 1 ) . '</td>
                <td>' . $member->created_at . '</td>
                <td>' . $member->name . '</td>
                <td>' . $member->email . '</td>
                <td>' . $member->invitation_code . '</td>
                <td>' . $member->ranking->name . '</td>
                <td>' . $member->capital . '</td>
                <td>' . ( $member->sponsor ? $member->sponsor->name : '-' )  . '</td>
                <td>' . ( $member->status == 1 ? 'Active' : 'Inactive' ) . '</td>
            ';
        }

        $html .= '</tbody></table>';

        Helper::exportReport( $html, 'member' );
    }
}
