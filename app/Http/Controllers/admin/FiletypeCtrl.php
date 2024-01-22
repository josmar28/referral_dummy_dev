<?php

namespace App\Http\Controllers\admin;


use App\Filetypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DeviceTokenCtrl;
use App\Http\Controllers\ParamCtrl;

class FiletypeCtrl extends Controller
{
    public function index()
    {
        $data = Filetypes::
        orderBy('id','asc')
        ->paginate(20);

        return view('admin.filetypes',
    [
        'data' => $data
    ]);
    }

    public function filetypeOptions(Request $req)
    {
        $data = $req->all();
        $match = array(
            'id' => $req->id
        );

        $upload = Filetypes::updateOrCreate($match,$data);

        if($upload->wasRecentlyCreated){
            Session::put("types_message","File types successfully added");
            Session::put("types",true);   
        }else{
            Session::put("update_types_message","File types successfully updated");
            Session::put("update_types",true);    
        }

        return Redirect::back();
    }

    public function filetypesBody(Request $req)
    {

        $data = Filetypes::find($req->id);

        return view('admin.filetypes_body',[
            'data' => $data
        ]);
    }
}


