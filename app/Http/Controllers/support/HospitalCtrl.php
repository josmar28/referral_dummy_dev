<?php

namespace App\Http\Controllers\support;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Muncity;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Facility;
use Illuminate\Support\Facades\Session;

class HospitalCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('support');
    }

    public function index()
    {
        $user = Session::get('auth');
        $muncity = Muncity::where('province_id',$user->province)
                    ->orderBy('description','asc')->get();
        $info = Facility::find($user->facility_id);
        return view('support.hospital',[
            'title' => 'Hospital Information',
            'muncity' => $muncity,
            'info' => $info
        ]);
    }

    public function update(Request $req)
    {
        $user = Session::get('auth');
        $data = array(
            'name' => $req->facility_name,
            'license_no' => $req->license_no,
            'abbr' => $req->abbr,
            'muncity' => $req->muncity,
            'brgy' => $req->brgy,
            'address' => $req->address,
            'contact' => $req->contact,
            'email' => Crypt::encrypt($req->email),
            'status' => $req->status
        );
        Facility::where('id',$user->facility_id)
            ->update($data);
        return redirect()->back()->with('status','updated');
    }

    public function license_no(Request $req)
    {
        $user = Session::get('auth');

        Facility::where('id',$user->facility_id)
            ->update([
                'license_no' => $req->license_no
            ]);

        Session::put('license_no_saved',true);
    }
}
