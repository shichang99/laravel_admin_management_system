<?php

namespace App\Services;

use App\Models\{
    SysSetting,
};

use Helper;

class SettingService {

    public static function allSettings( $request ) {

        $filter = false;

        $setting = SysSetting::select( 'sys_settings.*' );
        
        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $setting->whereBetween( 'sys_settings.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $setting->whereBetween( 'sys_settings.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->key ) ) {
            $setting->where( 'key', $request->key );
            $filter = true;
        }

        if ( $request->input( 'order.0.column' ) != 0 ) {

            switch ( $request->input( 'order.0.column' ) ) {
                case 1:
                    $setting->orderBy( 'sys_settings.created_at', $request->input( 'order.0.dir' ) );
                    break;
                case 5:
                    $setting->orderBy( 'sys_settings.status', $request->input( 'order.0.dir' ) );
                    break;
            }
        }

        
        $settingCount = $setting->count();

        $limit = $request->input( 'length' );
        $offset = $request->input( 'start' );

        $settingObject = $setting->skip( $offset )->take( $limit );
        $settings = $settingObject->get();

        $setting = SysSetting::select(
            \DB::raw( 'COUNT(sys_settings.id) as total'
        ) );

        if ( !empty( $request->created_date ) ) {
            if ( str_contains( $request->created_date, 'to' ) ) {
                $dates = explode( ' to ', $request->created_date );
                $setting->whereBetween( 'sys_settings.created_at', [ $dates[0] . ' 00:00:00' , $dates[1] . ' 23:59:59' ] );
            } else {
                $setting->whereBetween( 'sys_settings.created_at', [ $request->created_date . ' 00:00:00' , $request->created_date . ' 23:59:59' ] );
            }
            $filter = true;
        }

        if ( !empty( $request->key ) ) {
            $setting->where( 'key', $request->key );
            $filter = true;
        }

        
        $setting = $setting->first();

        $data = [
            'settings' => $settings,
            'draw' => $request->draw,
            'recordsFiltered' => $filter ? $settingCount : $setting->total,
            'recordsTotal' => SysSetting::select( \DB::raw( 'COUNT(id) as total' ) )->first()->total,
        ];

        return $data;
    }

    public static function oneSetting( $request ) {

        return response()->json( SysSetting::find( $request->id ) );
    }

    public static function createSetting( $request ) {

        $request->validate( [
            'display_name' => 'required',
            'key' => 'required|max:50|unique:sys_settings,key',
            'value' => 'required',
        ] );

        $createSetting = SysSetting::create( [
            'created_by' => auth()->user()->id,
            'name' => [
                'en' => $request->display_name,
                \App::getLocale() => $request->display_name,
            ],
            'key' => $request->key,
            'value' => $request->value,
            'type' => 1,
            'status' => 1,
        ] );

        return $createSetting;
    }

    public static function updateSetting( $request ) {

        $request->validate( [
            'display_name' => 'required',
            'key' => 'required|max:50|unique:sys_settings,key,' . $request->id,
            'value' => 'required',
        ] );

        $updateSetting = SysSetting::find( $request->id );
        $updateSetting->name = $request->display_name;
        $updateSetting->key = $request->key;
        $updateSetting->value = $request->value;
        $updateSetting->updated_by = auth()->user()->id;
        $updateSetting->save();

        return $updateSetting;
    }
}