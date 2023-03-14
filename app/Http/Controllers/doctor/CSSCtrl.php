<?php

namespace App\Http\Controllers\doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activity;
use App\VitalSigns;
use App\PhysicalExam;
use App\Baby;
use App\Barangay;
use App\Facility;
use App\Http\Controllers\DeviceTokenCtrl;
use App\Http\Controllers\ParamCtrl;
use App\Icd10;
use App\Muncity;
use App\CSS;
use App\PatientForm;
use App\Patients;
use App\PregnantForm;
use App\Pregnancy;
use App\Profile;
use App\Events\PreferredNotif;
use App\Province;
use App\Tracking;
use App\User;
use Illuminate\Support\Facades\Input;
use \Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;


class CSSCtrl extends Controller
{
   public function index()
   {
     $user = Session::get('auth');

    $data = CSS::select('css.*','facility.name as fac_name',
                        DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
                        DB::raw("DATE_FORMAT(css.date_of_visit,'%M %d, %Y %h:%i %p') as date_of_visit")
                        )
                ->leftJoin('facility','facility.id','=','css.fac_id')
                ->leftjoin('patient_form','patient_form.code','=','css.patient_code')
                ->leftjoin('patients','patients.id','=','patient_form.patient_id')
                ->where('fac_id',$user->facility_id)
                ->paginate(10);

    $total = count($data);
    return view('doctor.css',[
        'data' => $data,
        'total' => $total
    ]);
   }

   public function css(Request $req)
   {

   $hospital_id = Session::get('auth')->facility_id;
   $hospital = Facility::find($hospital_id)->name;
   $code = $req->code;

       return view('doctor.css_body',[
           'hospital_id' => $hospital_id,
           'hospital' => $hospital,
           'code' => $code
       ]);
   }


   public function cssAdd(Request $req)
   {
       $data = $req->all();

     $create = CSS::create($data);

     if($create->wasRecentlyCreated)
       {
           Session::put('cssAdd',true);
       }

       return Redirect::back();
       

   }

   static function checkCSS($code)
   {
       $checker = CSS::select('patient_code')
                   ->where('patient_code',$code)->pluck('patient_code');
       
       if(count($checker) > 0)
       {
           return 'yes';
       }
       else
       {
           return 'no';
       }
   }

}
