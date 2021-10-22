<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;

use App\Models\Setting;
use Yajra\Datatables\Datatables;

use Carbon\Carbon;
use Auth;
use DB;
use Validator;

class SettingController extends BaseController{
    
    public function indexList(Request $request){
        $breadcrumb = array(
            (object) ['name' => 'Dashboard', 'link' => 'welcome'],
            (object) ['name' => 'Setting', 'link' => 'setting']
        );

        $data = array(
            'breadcrumb' => $breadcrumb
        );
        return view('admin/pages/list-setting', $data);
    }

    /* API */
    public function commonList(Request $request){
        $list_data = Setting::orderBy('setting_name', 'asc')
                        ->get();

        return Datatables::of($list_data)
                ->editColumn('created_at', function($item){
                    return $item->created_at->format('j M Y H:i').' WIB';
                })
                ->addColumn('action', function($item){
                    $data = array(
                        'id' => $item->setting_id,
                        'name' => $item->setting_name
                    );
                    return $data;
                })
                ->make(true);
    }

    public function actionSave(Request $request){
        $input = (object) $request->input();
        if(empty($input->setting_id)){
            return Redirect::back();
        }else{
            if($item = Setting::find($input->setting_id)){
                $setting = $item;
            }else{
                return Redirect::back();
            }
        }
        $setting->setting_content     = $input->setting_content;
        
        if($setting->save()){
            return ['status' => 200, 'message' => 'Successfully save record!'];
        }else{
            return ['status' => 201, 'message' => 'Operation error'];
        }
    }
}