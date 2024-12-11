<?php

namespace App\Http\Controllers\admin;

use App\Activity;
use App\Barangay;
use App\Facility;
use App\Login;
use App\Province;
use App\Seen;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PregnantCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        //$this->middleware('doctor');
    }

    public function index (Request $req)
    {
        $user = Session::get('auth');

        $data = \App\PregnantFormv2::selectRaw(
        't2.maxid as notif_id , ROUND(DATEDIFF(CURDATE(),pregnant_formv2.lmp) / 7, 2) as now, pregnant_formv2.lmp,
         t2.maxaog,CONCAT(patients.fname," ",patients.mname," ",patients.lname) as woman_name, tracking.id as id, tracking.*, tracking.code as patient_code, CONCAT(action.fname," ",action.mname," ",action.lname) as action_md'
         )
        // ->leftJoin(\DB::raw('(SELECT referred_to, max(id) as maxid, max(code) as maxcode FROM activity B group by code ORDER BY B.id DESC ) AS t3'), function($join) {
        //     $join->on('pregnant_formv2.code', '=', 't3.maxcode');
        //         })
        ->leftJoin(\DB::raw('(SELECT *, max(id) as maxid, max(aog) as maxaog, max(unique_id) as maxunique_id FROM sign_and_symptoms A group by unique_id) AS t2'), function($join) {
            $join->on('pregnant_formv2.unique_id', '=', 't2.maxunique_id');
            })
        ->join('tracking','pregnant_formv2.code','=','tracking.code')
        // ->leftJoin("activity","activity.id","=","t3.maxid")
        ->leftJoin('patients','patients.id','=','pregnant_formv2.patient_woman_id')
        ->leftJoin('users as action','action.id','=','tracking.action_md')
        ->whereRaw('ROUND(t2.maxaog, 0) >= 34')
        ->where('tracking.status','!=','referred')
        // ->where('tracking.status','!=','discharged')
        ->orderBy('t2.maxid','desc');
       
      
        if($req->search)
        {
            $keyword = $req->search;
            $data = $data->where(function($q) use ($keyword){
                $q->where('patients.lname',"like","%$keyword%")
                    ->orwhere('patients.fname',"like","%$keyword%")
                    ->orwhere('tracking.code',"like","%$keyword%");
            });
        }

        if($req->date_range)
        {
            $date = $req->date_range;
            $range = explode('-',str_replace(' ', '', $date));
            $start = $range[0];
            $end = $range[1];
        }else
        {
        $start = Carbon::now()->startOfYear()->format('m/d/Y');
        $end = Carbon::now()->endOfYear()->format('m/d/Y');
        }

        $data = $data->distinct()->paginate(15);

        // dd($data);

        return view('admin.aogweeks',[
            "data" => $data,
            'keyword' => $keyword,
            'start' => $start,
            'end' => $end
        ]);
    }
}
