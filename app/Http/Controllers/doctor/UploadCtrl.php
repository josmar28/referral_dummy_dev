<?php

namespace App\Http\Controllers\doctor;


use App\Uploads;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UploadCtrl extends Controller
{
    public function uploadBody(Request $req)
    {
        $user = Session::get('auth');
        $facility_id = $user->facility_id;
        $code = $req->code;
        $data = Uploads::select("uploads.*",
        "filetypes.description as file_type",
        "users.fname",
        "users.mname",
        "users.lname",
        "facility.name as facility_name",
        DB::raw("DATE_FORMAT(uploads.uploaded_date,'%M %d, %Y %h:%i %p') as uploaded_date"),
    ) ->leftjoin("filetypes","filetypes.id","=","uploads.type_id")
    ->leftjoin("users","users.id","=","uploads.uploaded_by")
    ->leftjoin("facility","facility.id","=","uploads.facility_uploaded")
     ->where('uploads.referral_code',$code)
     ->get();
        
        
        return view('doctor.upload_body',[
            'code' => $code,
            'data' => $data,
            'facility_id' => $facility_id
        ]);
    }
    
    public function ViewuploadBody(Request $req)
    {
        $user = Session::get('auth');
        $facility_id = $user->facility_id;
        $code = $req->code;
        $data = Uploads::select("uploads.*",
        "filetypes.description as file_type",
        "users.fname",
        "users.mname",
        "users.lname",
        "facility.name as facility_name",
        DB::raw("DATE_FORMAT(uploads.uploaded_date,'%M %d, %Y %h:%i %p') as uploaded_date"),
    ) ->leftjoin("filetypes","filetypes.id","=","uploads.type_id")
    ->leftjoin("users","users.id","=","uploads.uploaded_by")
    ->leftjoin("facility","facility.id","=","uploads.facility_uploaded")
     ->where('uploads.referral_code',$code)
     ->get();
        
        
        return view('doctor.upload_body',[
            'code' => $code,
            'data' => $data,
            'facility_id' => $facility_id
        ]);
    }

    public function uploadFile(Request $req)
    {
        Session::put('unique_referral_code',$req->refer_code);
        $user = Session::get('auth');
        $refer_code = $req->refer_code;

        mkdir("app/uploads/$refer_code");
        
            foreach($req->file as $num => $file)
            {   
                
                $validator = Validator::make($req->all(), [
                    'file.*' => 'required|mimetypes:application/pdf|max:5000'
                ]);

                if($validator->fails()) {
                    Session::put('validated_upload',true);
                    return Redirect::back();
                }
                


                $filename = $file->getClientOriginalName();
                $file->move(base_path('public/uploads/'.$refer_code), $filename);
                $data = array(
                    'name' => $filename,
                    'path' => "app/uploads/".$refer_code,
                    'uploaded_date' => date('Y-m-d H:i:s'),
                    'uploaded_by' => $user->id,
                    'facility_uploaded' => $user->facility_id,
                    'type_id' => $req->file_type[$num],
                    'referral_code' => $refer_code
                );
               Uploads::create($data);
               Session::put('upload_file',true);
               Session::put('upload_file_message','File Uploaded Successfully!');
            }
            return Redirect::back();
    }

    public function fileView($id)
    {
       $data = Uploads::find($id);

       return view('doctor.viewfile',[
           'data' => $data
       ]);
    }

    public function fileDelete($id)
    {
        $data = Uploads::find($id)->delete();
        Session::put('upload_file',true);
        Session::put('upload_file_message','File Deleted Successfully!');

        return Redirect::back();
    }
}
