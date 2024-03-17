<?php

namespace App\Services;

use App\Models\{
    UnderMaintenance,
};

use Illuminate\Support\Facades\{
    Crypt,
};

use Helper;

class MaintenanceService {

    public static function allMaintenances( $request ) {

        $filter = false;

        $maintenance = UnderMaintenance::select( 'under_maintenances.*' );
        
        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $maintenance->whereBetween( 'under_maintenances.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $maintenance->whereBetween( 'under_maintenances.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->type ) ) {
            $maintenance->where( 'type', $request->type );
            $filter = true;
        }

        $maintenance->orderBy( 'under_maintenances.type', 'ASC' );

        if ( $request->input( 'order.0.column' ) != 0 ) {

            switch ( $request->input( 'order.0.column' ) ) {
                case 1:
                    $maintenance->orderBy( 'under_maintenances.created_at', $request->input( 'order.0.dir' ) );
                    break;
                case 5:
                    $maintenance->orderBy( 'under_maintenances.status', $request->input( 'order.0.dir' ) );
                    break;
            }
        }
        
        $maintenanceCount = $maintenance->count();

        $limit = $request->input( 'length' );
        $offset = $request->input( 'start' );

        $maintenanceObject = $maintenance->skip( $offset )->take( $limit );
        $maintenances = $maintenanceObject->get();

        $maintenance = UnderMaintenance::select(
            \DB::raw( 'COUNT(under_maintenances.id) as total'
        ) );

        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $maintenance->whereBetween( 'under_maintenances.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $maintenance->whereBetween( 'under_maintenances.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->type ) ) {
            $maintenance->where( 'type', $request->type );
            $filter = true;
        }

        
        $maintenance = $maintenance->first();

        $data = [
            'maintenances' => $maintenances,
            'draw' => $request->draw,
            'recordsFiltered' => $filter ? $maintenanceCount : $maintenance->total,
            'recordsTotal' => UnderMaintenance::select( \DB::raw( 'COUNT(id) as total' ) )->first()->total,
        ];

        return $data;
    }

    public static function oneMaintenance( $request ) {

        return response()->json( UnderMaintenance::find( $request->id ) );
    }

    public static function createMaintenance( $request ) {

        $validator = \Validator::make( $request->all(), [
            'type' => 'required|unique:under_maintenances,type',
            'content' => 'required',
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'admin.maintenance.create' )->withErrors( $validator->errors() )->withInput();
        }

        try {

            $createMaintenance = UnderMaintenance::create( [
                'created_by' => auth()->user()->id,
                'type' => $request->type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'content' => [
                    'en' => $request->content,
                    \App::getLocale() => $request->content,
                ],
                'status' => 0,
            ] );

            \DB::commit();

            \Session::flash( 'success', __( 'maintenance.maintenance_created' ) );
            return redirect()->route( 'admin.maintenance.list' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }

        return $createMaintenance;
    }

    public static function updateMaintenance( $request ) {

        $mID = Crypt::decryptString( $request->encrypted_id );

        $validator = \Validator::make( $request->all(), [
            'content' => 'required',
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'admin.maintenance.modify', [ 'id' => $request->encrypted_id ] )->withErrors( $validator->errors() )->withInput();
        }

        \DB::beginTransaction();

        try {

            $updateMaintenance = UnderMaintenance::find( $mID );

            if ( !empty( $request->start_date ) ) {
                $updateMaintenance->start_date = $request->start_date;
            }
            if ( !empty( $request->end_date ) ) {
                $updateMaintenance->end_date = $request->end_date;
            }
            if ( !empty( $request->start_time ) ) {
                $updateMaintenance->start_time = $request->start_time . ':00';
            }
            if ( !empty( $request->end_time ) ) {
                $updateMaintenance->end_time = $request->end_time . ':00';
            }
            
            $updateMaintenance->content = $request->content;
            $updateMaintenance->updated_by = auth()->user()->id;
            $updateMaintenance->save();

            \DB::commit();
            
            \Session::flash( 'success', __( 'maintenance.maintenance_updated' ) );
            return redirect()->route( 'admin.maintenance.list' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }

    }

    public static function updateMaintenanceStatus( $request ) {
        $validator = \Validator::make( $request->all(), [
            'status' => 'required',
        ] );
     
        $id = Crypt::decryptString( $request->id );
        
        if ( $validator->fails() ) {
            return redirect()->route( 'admin.maintenance.list' )->withErrors( $validator->errors() )->withInput();
        }
        \DB::beginTransaction();

        try {

            $updateMaintenance = UnderMaintenance::find( $id );
            $updateMaintenance->status = $request->status;
            $updateMaintenance->save();

            \DB::commit();
            
            \Session::flash( 'success', __( 'maintenance.maintenance_edit' ) );
            return redirect()->route( 'admin.maintenance.list' );

        } catch ( \Throwable $th ) {

            \DB::rollBack();
            \Session::flash( 'error', $th->getMessage() . ' Line: ' . $th->getLine() );
            return back()->withErrors( $validator->errors() )->withInput();
        }
    }
}