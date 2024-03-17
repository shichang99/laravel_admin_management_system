<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\{
    Crypt,
};
use App\Models\{
    Announcement,
};

use Helper;

class AnnouncementService {

    public static function allAnnouncements( $request ) {

        $filter = false;
        
        $announcement = Announcement::select( 'announcements.*' );
    
        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $announcement->whereBetween( 'created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $announcement->whereBetween( 'created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->title ) ) {
            $filter = true;
            $announcement->where( 'title', 'LIKE', '%' . $request->title . '%' );
        }

        if ( !empty( $request->type ) ) {
            $filter = true;
            $announcement->where( 'type', $request->type );
        }

        if ( $request->input( 'order.0.column' ) != 0 ) {

            switch ( $request->input( 'order.0.column' ) ) {
                case 2:
                    $announcement->orderBy( 'announcements.created_at', $request->input( 'order.0.dir' ) );
                    break;
                case 5:
                    $announcement->orderBy( 'announcements.type', $request->input( 'order.0.dir' ) );
                    break;
                case 6:
                    $announcement->orderBy( 'announcements.status', $request->input( 'order.0.dir' ) );
                    break;
            }
        }

        $announcementCount = $announcement->count();

        $limit = $request->input( 'length' );
        $offset = $request->input( 'start' );
        
        $announcementObject = $announcement->skip( $offset )->take( $limit );
        $announcements = $announcementObject->get();
       
        $announcement = announcement::select( \DB::raw( 'COUNT(id) as total' ) );

        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $announcement->whereBetween( 'created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $announcement->whereBetween( 'created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->title ) ) {
            $filter = true;
            $announcement->where( 'title', 'LIKE', '%' . $request->title . '%' );
        }

        if ( !empty( $request->type ) ) {
            $filter = true;
            $announcement->where( 'type', $request->type );
        }

        $announcement = $announcement->first();

        $data = [
            'announcements' => $announcements,
            'draw' => $request->input( 'draw' ),
            'recordsFiltered' => $filter ? $announcementCount : $announcement->total,
            'recordsTotal' => announcement::select( \DB::raw( 'COUNT(id) as total' ) )->first()->total,
        ];

        return $data;        
    }
    public static function oneAnnouncement( $request ) {

        return response()->json( Announcement::find( Crypt::decryptString($request->id) ) );
    }
    public static function createAnnouncement( $request ) {

        $validator = \Validator::make( $request->all(), [
            'title' => 'required',
            'message' => 'required',
            'type' => 'required',
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'admin.announcement.create' )->withErrors( $validator->errors() )->withInput();
        }

        $image = '';
        if ( $request->has( 'image' ) )
        {
            $inputs = $request->all();

            $count = 1;

            foreach ( $inputs['image'] as $key=> $val )
            {
                $filePath = $inputs['image'][$key]->hashName();
                $file = $inputs['image'][$key];

                \Validator::make( $inputs, [
                    'image.*' => 'required|mimes:jpeg,bmp,png|max:20000'
                    ], [
                        'image.*.required' => 'Please upload an image',
                        'image.*.mimes' => 'Only jpeg and png are allowed',
                        'image.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
                ] )->validate();

                $images = $inputs['image'][$key];

                $folderName = Helper::uploadCloudFolderName() . '/announcement';
                Storage::disk( 's3' )->put( $folderName . '/' . $filePath, file_get_contents( $images),'public' );

                // Storage::disk( 's3' )->put( $folderName . '/' . $filePath, file_get_contents( $images ) );

                $image .= $folderName . '/' . $filePath;
                if ( $count < count( $inputs['image'] ) ) {
                    $image .= '|';
                }

                $count++;
            }
        }

        \DB::beginTransaction();

        try {
            
            $createAnnouncement = Announcement::create( [
                'title' => [
                    'en' => $request->title, // Here ensure default language (English) is always set, regardless of language type selected
                    $request->language => $request->title,
                ],
                'message' => [
                    'en' => $request->message,
                    $request->language => $request->message,
                ],
                'type' => $request->type,
                'status' => 1,
                'image' => $image,
                'created_by' => auth()->user()->id,
            ] );

            \DB::commit();

            \Session::flash( 'success', __( 'announcement.announcement_created' ) );
            return redirect()->route( 'admin.announcement.list' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }

        return $createAnnouncement;
    }

    public static function updateAnnouncement( $request ) {

        $validator = \Validator::make( $request->all(), [
            'title' => 'required',
            'message' => 'required',
            'type' => 'required',
        ] );
     
        $id = Crypt::decryptString( $request->encrypted_id );
        
        if ( $validator->fails() ) {
            return redirect()->route( 'admin.annuoncement.modify', [ 'id' => $request->encrypted_id ] )->withErrors( $validator->errors() )->withInput();
        }
        \DB::beginTransaction();
       
        try {

            $updateAnnouncement = Announcement::find( $id );

            if ( $request->has( 'image' ))
            {
                $inputs = $request->all();
                $image= '';
                $count = 1;
                foreach( $inputs['image'] as $key=> $val)
                {
                    $filePath = $inputs['image'][$key]->hashName();
                    $file = $inputs['image'][$key];

                    \Validator::make( $inputs, [
                        'image.*' => 'required|mimes:jpeg,bmp,png,pdf|max:20000'
                        ],[
                            'image.*.required' => 'Please upload an image',
                            'image.*.mimes' => 'Only jpeg,png and PDF are allowed',
                            'image.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
                    ])->validate();

                    $images = $inputs['image'][$key];

                    $folderName = Helper::uploadCloudFolderName().'/announcement';
                    Storage::disk( 's3' )->put( $folderName.'/'.$filePath,file_get_contents( $images),'public' );

                    $image .= $folderName.'/'.$filePath;
                    if ( $count < count( $inputs['image']))
                    {
                        $image .='|';
                    }
                    $count++;
                }
                $updateAnnouncement->image = $image;
            }
            $updateAnnouncement->title = [$request->language => $request->title];
            $updateAnnouncement->message = [$request->language => $request->message];
            $updateAnnouncement->type = $request->type;
            $updateAnnouncement->updated_by = auth()->user()->id;
            $updateAnnouncement->save();

            \DB::commit();
            
            \Session::flash( 'success', __( 'announcement.announcement_edit' ) );
            return redirect()->route( 'admin.announcement.modify', [ 'id' => $request->encrypted_id ] );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }
    public static function updateAnnouncementStatus( $request)
    {
        $validator = \Validator::make( $request->all(), [
            'status' => 'required',
        ] );
     
        $id = Crypt::decryptString( $request->id );
        
        if ( $validator->fails() ) {
            return redirect()->route( 'admin.annuoncement.list' )->withErrors( $validator->errors() )->withInput();
        }
        \DB::beginTransaction();

        try {

            $updateAnnouncement = Announcement::find( $id );
            $updateAnnouncement->status = $request->status;
            $updateAnnouncement->save();

            \DB::commit();
            
            \Session::flash( 'success', __( 'announcement.announcement_edit' ) );
            return redirect()->route( 'admin.announcement.list' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }

    public function announcementLang( $request ) {

        app()->setLocale( $request->locale );

        $announcement = Announcement::find( Crypt::decryptString( $request->id ) );

        return response()->json( $announcement );
    }
    
    // Member Site
    public function getAllAnnouncement( $request ) {

        $data['announcement'] = Announcement::where( 'status', 1)
            ->where('type',1)
            ->orderBy( 'created_at', 'DESC' )
            ->get();

        $data['recordsTotal'] = count( $data['announcement'] );

        return $data;
    }

}