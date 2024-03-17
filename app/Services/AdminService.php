<?php

namespace App\Services;

use App\Models\{
    Admin,
    ActivityLog,
    Role as RoleModel
};

class AdminService {

    public static function allAdmins( $request ) {

        $filter = false;

        $limit = $request->input( 'length' );
        $offset = $request->input( 'start' );

        $admin = Admin::select( 'admins.*', 'roles.name as role_name' );
        $admin->leftJoin( 'roles', 'admins.role', '=', 'roles.id' );

        if ( !empty( $request->registered_date ) ) {
            if ( str_contains( $request->registered_date, 'to' ) ) {
                $dates = explode( ' to ', $request->registered_date );
                $admin->whereBetween( 'admins.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $admin->whereBetween( 'admins.created_at', [ $request->registered_date . ' 00:00:00' , $request->registered_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->username ) ) {
            $filter = true;
            $admin->where( 'admins.name', $request->username );
        }

        if ( !empty( $request->email ) ) {
            $filter = true;
            $admin->where( 'admins.email', $request->email );
        }

        if ( !empty( $request->roles ) ) {
            $filter = true;
            $admin->where( 'admins.role', $request->roles );
        }

        if ( !empty( $request->status ) ) {
            $filter = true;
            $admin->where( 'admins.status', $request->status );
        }


        if ( $request->input( 'order.0.column' ) != 0 ) {

            switch ( $request->input( 'order.0.column' ) ) {
                case 1:
                    $admin->orderBy( 'admins.created_at', $request->input( 'order.0.dir' ) );
                    break;
                case 2:
                    $admin->orderBy( 'admins.name', $request->input( 'order.0.dir' ) );
                    break;
                case 3:
                    $admin->orderBy( 'admins.email', $request->input( 'order.0.dir' ) );
                    break;
            }
        }

        $adminCount = $admin->count();
        
        $adminObject = $admin->skip( $offset )->take( $limit );
        $admins = $adminObject->get();

        $admin = Admin::select( \DB::raw( 'COUNT(id) as total' ) );

        if ( !empty( $request->registered_date ) ) {
            if ( str_contains( $request->registered_date, 'to' ) ) {
                $dates = explode( ' to ', $request->registered_date );
                $admin->whereBetween( 'admins.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $admin->whereBetween( 'admins.created_at', [ $request->registered_date . ' 00:00:00' , $request->registered_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->username ) ) {
            $filter = true;
            $admin->where( 'admins.name', $request->username );
        }

        if ( !empty( $request->email ) ) {
            $filter = true;
            $admin->where( 'admins.email', $request->email );
        }

        if ( !empty( $request->roles ) ) {
            $filter = true;
            $admin->where( 'admins.role', $request->roles );
        }

        if ( !empty( $request->status ) ) {
            $filter = true;
            $admin->where( 'admins.status', $request->status );
        }

        $admin = $admin->first();

        $data = [
            'admins' => $admins,
            'draw' => $request->input( 'draw' ),
            'recordsFiltered' => $filter ? $adminCount : $admin->total,
            'recordsTotal' => Admin::select( \DB::raw( 'COUNT(id) as total' ) )->first()->total,
        ];

        return $data;        
    }

    public static function oneAdmin( $request ) {

        return response()->json( Admin::find( $request->id ) );
    }

    public static function createAdmin( $request ) {

        $request->validate( [
            'username' => 'required|max:25|unique:admins,name',
            'email' => 'required|max:25|unique:admins,email|email|regex:/(.+)@(.+)\.(.+)/i',
            'role' => 'required',
            'password' => 'required|min:8|max:255',
        ] );

        $createAdmin = Admin::create( [
            'name' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'status' => 1,
            'password' => \Hash::make( $request->password ),
            'created_by' => auth()->user()->id,
        ] );

        $roleModel = RoleModel::find( $request->role );

        $createAdmin->syncRoles( [ $roleModel->name ] );

        return $createAdmin;
    }

    public static function updateAdmin( $request ) {

        $request->validate( [
            'username' => 'required|max:25|unique:admins,name,' . $request->id,
            'email' => 'required|max:25|unique:admins,email,' . $request->id.'|email|regex:/(.+)@(.+)\.(.+)/i',
            'role' => 'required',
            'password' => 'min:8|max:25',
        ] );

        $updateAdmin = Admin::find( $request->id );
        $updateAdmin->id = $request->id;
        $updateAdmin->name = $request->username;
        $updateAdmin->email = $request->email;
        $updateAdmin->role = $request->role;
        $updateAdmin->updated_by = auth()->user()->id;

        if ( !empty( $request->password ) ) {
            $updateAdmin->password = \Hash::make( $request->password );
        }

        $roleModel = RoleModel::find( $request->role );
        $updateAdmin->syncRoles( [ $roleModel->name ] );
        $updateAdmin->save();

        return $updateAdmin;
    }

    public static function updateAdminStatus( $request ) {

        $updateAdmin = Admin::find( $request->id );
        $updateAdmin->status = $request->status;
        $updateAdmin->save();

        return $updateAdmin;
    }

    public static function allAdminLogs( $request ) {

        $filter = false;

        $limit = $request->input( 'length' );
        $offset = $request->input( 'start' );

        $adminLog = ActivityLog::with( 'admin' )->select( 'activity_log.*' );
        $adminLog->leftJoin( 'admins', 'activity_log.causer_id', '=', 'admins.id' );
        $adminLog->where( 'activity_log.causer_type', 'LIKE', '%' . 'Admin' . '%' );

        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $adminLog->whereBetween( 'activity_log.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $adminLog->whereBetween( 'activity_log.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->username ) ) {
            $filter = true;
            $adminLog->where( 'admins.name', $request->username );
        }

        $adminLog->orderBy( 'activity_log.created_at', 'DESC' );

        if ( $request->input( 'order.0.column' ) != 0 ) {

            switch ( $request->input( 'order.0.column' ) ) {
                case 1:
                    $adminLog->orderBy( 'activity_log.created_at', $request->input( 'order.0.dir' ) );
                    break;
                case 2:
                    $adminLog->orderBy( 'admins.name', $request->input( 'order.0.dir' ) );
                    break;
            }
        }

        $adminLogCount = $adminLog->count();
        
        $adminLogObject = $adminLog->skip( $offset )->take( $limit );
        $adminLogs = $adminLogObject->get();

        $adminLog = ActivityLog::select( \DB::raw( 'COUNT(activity_log.id) as total' ) );
        $adminLog->leftJoin( 'admins', 'admins.id', '=', 'activity_log.causer_id' );
        $adminLog->where( 'activity_log.causer_type', 'LIKE', '%' . 'Admin' . '%' );

        if ( !empty( $request->registered_date ) ) {
            if ( str_contains( $request->registered_date, 'to' ) ) {
                $dates = explode( ' to ', $request->registered_date );
                $adminLog->whereBetween( 'activity_log.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $adminLog->whereBetween( 'activity_log.created_at', [ $request->registered_date . ' 00:00:00' , $request->registered_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->username ) ) {
            $filter = true;
            $adminLog->where( 'admins.name', $request->username );
        }

        $adminLog = $adminLog->first();

        $data = [
            'adminLogs' => $adminLogs,
            'draw' => $request->input( 'draw' ),
            'recordsFiltered' => $filter ? $adminLogCount : $adminLog->total,
            'recordsTotal' => ActivityLog::select( \DB::raw( 'COUNT(id) as total' ) )->first()->total,
        ];

        return $data;        
    }
}