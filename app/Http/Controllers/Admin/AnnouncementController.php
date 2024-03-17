<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\{
    AnnouncementService,
};
use App\Models\{
    Announcement,
};

class AnnouncementController extends Controller
{
    public function index( Request $request ) {

        $this->data['header']['title'] = __( 'template.announcements' );
        $this->data['content'] = 'admin.announcement.index';
        $this->data['data']['types'] = [
            [
                'title' => __( 'datatables.all' ),
                'value' => '',
            ],
            [
                'title' => __( 'announcement.announcement' ),
                'value' => '1',
            ],
            [
                'title' => __( 'announcement.marquee' ),
                'value' => '2',
            ],
        ];

        return view( 'admin.main' )->with( $this->data );
    }

    public function create() {

        $this->data['header']['title'] = __( 'announcement.announcement_create' );
        $this->data['content'] = 'admin.announcement.create';
        $this->data['data']['languages'] = [
            [
                'title' => 'English',
                'value' => 'en',
            ],
            [
                'title' => '中文',
                'value' => 'zh',
            ],
        ];
        $this->data['data']['types'] = [
            [
                'title' => __( 'announcement.announcement' ),
                'value' => '1',
            ],
            [
                'title' => __( 'announcement.marquee' ),
                'value' => '2',
            ],
        ];

        return view( 'admin.main' )->with( $this->data );
    }

    public function allAnnouncements( Request $request ) {

        return AnnouncementService::allAnnouncements( $request );
    }

    public function oneAnnouncement( Request $request ) {

        return AnnouncementService::oneAnnouncement( $request );
    }
    public function modify( Request $request ) {

        $this->data['header']['title'] = __( 'announcement.announcement_edit' );
        $this->data['content'] = 'admin.announcement.modify';
        $announcement = Announcement::find( \Crypt::decryptString( $request->id ));
        $this->data['data']['announcements'] = $announcement;
        $this->data['data']['languages'] = [
            [
                'title' => 'English',
                'value' => 'en',
            ],
            [
                'title' => '中文',
                'value' => 'zh',
            ],
        ];
        $this->data['data']['types'] = [
            [
                'title' => __( 'announcement.announcement' ),
                'value' => '1',
            ],
            [
                'title' => __( 'announcement.marquee' ),
                'value' => '2',
            ],
        ];
        return view( 'admin.main' )->with( $this->data );
    }

    public function createAnnouncement( Request $request ) {

        return AnnouncementService::createAnnouncement( $request );
    }

    public function updateAnnouncement( Request $request ) {

        return AnnouncementService::updateAnnouncement( $request );
    }
    public function updateAnnouncementStatus( Request $request ) {

        return AnnouncementService::updateAnnouncementStatus( $request );
    }

    public function announcementLang( Request $request ) {

        return AnnouncementService::announcementLang( $request );
    }
}
