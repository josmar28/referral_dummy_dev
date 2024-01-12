<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('resources/img/dohro12logo2.png') }}">
    <meta http-equiv="cache-control" content="max-age=0" />
    <title>DOH CHD XII – Referral System</title>
    <!-- <title>{{ (isset($title)) ? $title : 'Referral System'}}</title> -->
    <!-- SELECT 2 -->
    <!-- <link href="{{ asset('resources/plugin/select2/select2.min.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('resources/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('resources/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/bootstrap-theme.min.css') }}" rel="stylesheet">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('resources/plugin/Ionicons/css/ionicons.min.css') }}">

    <!-- Font awesome -->
    <link href="{{ asset('resources/assets/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/fontawesome/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/fontawesome/css/solid.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/fontawesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('resources/assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('resources/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/assets/css/AdminLTE.min.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    
    <link href="{{ asset('resources/plugin/datepicker/datepicker3.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/plugin/Lobibox/lobibox.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('resources/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link href="{{ asset('resources/plugin/daterangepicker_old/daterangepicker-bs3.css') }}" rel="stylesheet">

    <link href="{{ asset('resources/plugin/table-fixed-header/table-fixed-header.css') }}" rel="stylesheet">

    <link rel="manifest" href="{{ asset('/manifest.json') }}" />
    <title>
        @yield('title','Home')
    </title>

    @yield('css')
    <style>
        body {
            background: url('{{ asset('resources/img/backdrop.png') }}'), -webkit-gradient(radial, center center, 0, center center, 460, from(#ccc), to(#ddd));
        }
        .loading {
            background: rgba(255, 255, 255, 0.9) url('{{ asset('resources/img/loading.gif')}}') no-repeat center;
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            z-index:999999999;
            display: none;
        }

        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: rgba(38, 125, 61, 0.92);
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 4px;
        }
        #myBtn:hover {
            background-color: #555;
        }
        .modal-xl {
        width: 90%;
        margin: auto;
        }
        .sign_symthoms_table th
        {
            text-align:center;
        }
        .sign_symthoms_table td
        {
            text-align:center;
        }
        .sign_symthoms_table_box td
        {
            text-align:left;
        }
        .dropdown-left-manual {
        right: 0;
        left: auto;
        padding-left: 1px;
        padding-right: 1px;
        }
    </style>
</head>

<body>

<!-- Fixed navbar -->
<div id="app_div">
<nav class="navbar navbar-default fixed-top" >
    <div class="header" style="background-color:#2F4054;padding:10px;">
        <div>
            <div class="col-md-4">
                <div class="pull-left">
                    <?php
                    $user = Session::get('auth');
                    $t = '';
                    $dept_desc = '';
                    if($user->level=='doctor')
                    {
                        $t='Dr.';
                    }else if($user->level=='support'){
                        $dept_desc = ' / IT Support';
                    }

                    if($user->department_id > 0)
                    {
                        $dept_desc = ' / ' . \App\Department::find($user->department_id)->description;
                    }

                    ?>
                    <span class="title-info">Welcome,</span> <span class="title-desc">{{ $t }} {{ $user->fname }} {{ $user->lname }} {{ $dept_desc }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <center>
                    <?php
                        $user_logs = \App\Login::where("userId",$user->id)->orderBy("id","desc")->first();
                        $login_time = $user_logs->login;
                        $user_logs->logout == "0000-00-00 00:00:00" ? $logout_time = explode(' ',$user_logs->login)[0].' 23:59:59' : $logout_time = $user_logs->logout;
                        $logout_time = date("M d, Y H:i:s",strtotime($logout_time));
                    ?>
                    <span class="title-info">Logout Time: </span> <strong class="text-red" id="logout_time"> </strong>&nbsp;
                    <button href="#setLogoutTime" data-toggle="modal" class="btn btn-xs btn-danger" onclick="openLogoutTime();"><i class="fa clock-o"></i> Set Time to Logout</button>
                </center>
            </div>
            <div class="col-md-4">
                <div class="pull-right">
                    @if($user->level != 'vaccine')
                        <span class="title-desc">{{ \App\Facility::find($user->facility_id)->name }}</span>
                    @endif
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
    <div class="header" style="background-color:#59ab91;padding:10px;">
        <div class="container">
            @if($user->level == 'opcen')
                <img src="{{ asset('resources/img/opcen_banner4.png') }}" class="img-responsive" />
            @elseif($user->level == 'bed_tracker')
                <img src="{{ asset('resources/img/bed_banner4.png') }}" class="img-responsive" />
            @elseif($user->level == 'vaccine')
                <img src="{{ asset('resources/img/updated_vaccine_logo4.png') }}" class="img-responsive" />
            @else
                <img src="{{ asset('resources/img/referral_banner4.png') }}" class="img-responsive" />
            @endif
        </div>
    </div>
    <div class="container-fluid" >
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
        </div>
        <?php
            $count = \App\Http\Controllers\doctor\ReferralCtrl::countReferral();
            $count1 = \App\Http\Controllers\doctor\AffiliatedCtrl::countAffiReferral();

            $allcount = $count + $count1;
            $count_chat = \App\Message::where('to', $user->id)
                ->where('read', false)
                ->groupBy('to')
                ->count();
                
            $user = Session::get('auth');
            
            $data = \App\PregnantFormv2::selectRaw('t2.maxid as notif_id, ROUND(DATEDIFF(CURDATE(),pregnant_formv2.lmp) / 7, 2) as now, pregnant_formv2.lmp, 
            t2.maxaog,CONCAT(patients.fname," ",patients.mname," ",patients.lname) as woman_name, tracking.code as patient_code, tracking.notif as notif')
            // ->leftJoin(\DB::raw('(SELECT referred_to, max(id) as maxid, max(code) as maxcode FROM activity B group by code ORDER BY B.id DESC ) AS t3'), function($join) {
            //     $join->on('pregnant_formv2.code', '=', 't3.maxcode');
            //         })
            ->leftJoin(\DB::raw('(SELECT *, max(id) as maxid, max(aog) as maxaog, max(unique_id) as maxunique_id FROM sign_and_symptoms A group by unique_id) AS t2'), function($join) {
                $join->on('pregnant_formv2.unique_id', '=', 't2.maxunique_id');
                })
            // ->leftJoin("activity","activity.id","=","t3.maxid")
            ->join('tracking','pregnant_formv2.code','=','tracking.code')
            ->leftJoin('patients','patients.id','=','pregnant_formv2.patient_woman_id')
            ->whereRaw('ROUND(t2.maxaog, 0) >= 34')
            ->where('tracking.notif','1')
            ->where('tracking.status','!=','referred')
            // ->where('tracking.status','!=','discharged')
            ->where('tracking.referred_to',$user->facility_id)
            ->orderBy('t2.maxid','desc')
            ->distinct()
            ->get();


            $datacount = \App\PregnantFormv2::selectRaw('t2.maxid as notif_id, ROUND(DATEDIFF(CURDATE(),pregnant_formv2.lmp) / 7, 0) as now, pregnant_formv2.lmp, 
            t2.maxaog,CONCAT(patients.fname," ",patients.mname," ",patients.lname) as woman_name, tracking.code as patient_code, tracking.notif as notif')
            // ->leftJoin(\DB::raw('(SELECT referred_to, max(id) as maxid, max(code) as maxcode FROM activity B group by code ORDER BY B.id DESC ) AS t3'), function($join) {
            //     $join->on('pregnant_formv2.code', '=', 't3.maxcode');
            //         })
            ->leftJoin(\DB::raw('(SELECT *, max(id) as maxid, max(aog) as maxaog, max(unique_id) as maxunique_id FROM sign_and_symptoms A group by unique_id) AS t2'), function($join) {
                $join->on('pregnant_formv2.unique_id', '=', 't2.maxunique_id');
                })
            // ->leftJoin("activity","activity.id","=","t3.maxid")
            ->join('tracking','pregnant_formv2.code','=','tracking.code')
            ->leftJoin('patients','patients.id','=','pregnant_formv2.patient_woman_id')
            ->whereRaw('ROUND(t2.maxaog, 0) >= 34')
            ->where('tracking.notif','1')
            ->where('tracking.status','!=','referred')
            // ->where('tracking.status','!=','discharged')
            ->where('tracking.referred_to',$user->facility_id)
            ->orderBy('t2.maxid','desc')
            ->distinct()
            ->get();

            $notif = 0;
            foreach($datacount as $dats)
            {
                if($dats->now  >= '34')
                {
                    $notif++;
                }
            }
            $link = 0;

            // dd($data);
        ?>
        <div id="navbar" class="navbar-collapse collapse" style="font-size: 13px;">
            <ul class="nav navbar-nav">
                @if($user->level=='doctor' || $user->level=='midwife' || $user->level=='medical_dispatcher' || $user->level=='nurse')
                    <li><a href="{{ url('doctor/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> Patients <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('doctor/patient') }}"><i class="fa fa-table"></i> List of Patients</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ url('doctor/accepted') }}"><i class="fa fa-user-plus"></i> Accepted Patients</a></li>
                            <!-- <li><a href="{{ url('doctor/affiliated/accepted') }}"><i class="fa fa-user-plus"></i> Accepted Affiliated Patients</a></li> -->
                            <li><a href="{{ url('doctor/discharge') }}"><i class="fa fa-ambulance"></i> Discharged Patients</a></li>
                            <li><a href="{{ url('doctor/transferred') }}"><i class="fa fa-ambulance"></i> Transfered Patients</a></li>
                            <li><a href="{{ url('doctor/cancelled') }}"><i class="fa fa-user-times"></i> Cancelled Patients</a></li>
                            <li><a href="{{ url('doctor/archived') }}"><i class="fa fa-archive"></i> Archived Patients</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ url('doctor/referred/track') }}"><i class="fa fa-line-chart"></i> Track Patient</a></li>
                            <li class="hide"><a href="{{ url('maintenance') }}"><i class="fa fa-line-chart"></i> Rerouted Patients</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ asset('doctor/affiliated') }}"><i class="fa fa-building"></i> Affiliated Facilities <small class="badge bg-red"> New</small></a></li>
                    <!--
                    <li><a href="{{ url('inventory').'/'.$user->facility_id }}"><i class="fa fa-calculator"></i> Inventory </a></li>
                     -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wheelchair"></i> Referral <span class="badge"><span class="count_referral">{{ $allcount }}</span> New</span><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('doctor/referral') }}"><i class="fa fa-ambulance"></i> Incoming &nbsp;&nbsp; <span class="badge"><span class="count_referral">{{ $count }}</span> New</span></a></li>
                            <li><a href="{{ asset('doctor/affiliated/referral') }}"><i class="fa fa-ambulance"></i> Affiliated Incoming &nbsp;&nbsp; <span class="badge"><span class="count_referral" id="count_referral">{{ $count1 }}</span> New</span></a></li>
                            <li><a href="{{ url('doctor/referred') }}"><i class="fa fa-user"></i> Referred Patients</a></li>
                            <!--
                            <li><a href="{{ url('maintenance') }}"><i class="fa fa-hospital-o"></i> Emergency Walk-In</a></li>
                            <li><a href="{{ url('doctor/report/incoming') }}"><i class="fa fa-sign-in"></i> Incoming Referral Report</a></li>
                            <li><a href="{{ url('doctor/report/outgoing') }}"><i class="fa fa-sign-out"></i> Outgoing Referral Report</a></li>
                            -->
                        </ul>
                    </li>
                    <!--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Report <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('admin/report/online') }}"><i class="fa fa-users"></i>Online Users</a></li>
                            <li><a href="{{ url('online/facility') }}"><i class="fa fa-hospital-o"></i>Online Facility</a></li>
                            <li><a href="{{ url('offline/facility') }}"><i class="fa fa-times-circle-o"></i>Offline Facility</a></li>
                            <li><a href="{{ url('onboard/facility') }}"><i class="fa fa-ambulance"></i>Onboard Facility</a></li>
                            <li><a href="{{ url('admin/report/consolidated/incomingv2') }}"><i class="fa fa-file-archive-o"></i>Consolidated</a></li>
                            <li><a href="{{ url('admin/statistics/incoming') }}"><i class="fa fa-certificate"></i>Statistics Report Incoming</a></li>
                            <li><a href="{{ url('admin/statistics/outgoing') }}"><i class="fa fa-certificate"></i>Statistics Report Outgoing</a></li>
                            <li><a href="{{ url('admin/er_ob') }}"><i class="fa fa-certificate"></i>Statistics Report ER OB</a></li>
                            <li><a href="{{ url('admin/average/user_online') }}"><i class="fa fa-certificate"></i>Average User's Online</a></li>
                        </ul>
                    </li>
                    -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Report <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('doctor/aog/weeks/'.$link) }}"><i class="fas fa-baby"></i> 34 Weeks above</a></li>
                            <li><a href="{{ url('admin/report/online') }}"><i class="fa fa-users"></i>Online Users</a></li>
                            <li><a href="{{ url('doctor/report/incidentIndex') }}"><i class="fa fa-table"></i>Incident Logs</a></li>
                            <li><a href="{{ url('online/facility') }}"><i class="fa fa-hospital-o"></i>Online Facility</a></li>
                            <li><a href="{{ url('offline/facility') }}"><i class="fa fa-times-circle-o"></i>Offline Facility</a></li>
                            <li><a href="{{ url('onboard/facility') }}"><i class="fa fa-ambulance"></i>Onboard Facility</a></li>
                            <li><a href="{{ url('onboard/users') }}"><i class="fa fa-ambulance"></i>Onboard Users <span class="badge bg-red">New</span></a></li>
                            <li><a href="{{ url('weekly/report') }}"><i class="fa fa-calendar-check-o"></i>Login Status <span class="badge bg-red">New</span></a></li>
                            <!--
                            <li><a href="{{ url('admin/report/referral') }}"><i class="fa fa-line-chart"></i>Referral Status</a></li>
                            <li><a href="{{ url('admin/daily/users') }}"><i class="fa fa-users"></i>Daily Users</a></li>
                            <li><a href="{{ url('admin/daily/referral') }}"><i class="fa fa-building"></i>Daily Hospital</a></li>
                            -->
                            <li><a href="{{ url('admin/report/consolidated/incomingv2') }}"><i class="fa fa-file-archive-o"></i>Consolidated</a></li>
                            <li><a href="{{ url('admin/statistics/incoming') }}"><i class="fa fa-certificate"></i>Statistics Report Incoming</a></li>
                            <li><a href="{{ url('admin/statistics/outgoing') }}"><i class="fa fa-certificate"></i>Statistics Report Outgoing</a></li>
                            <li><a href="{{ url('admin/er_ob') }}"><i class="fa fa-certificate"></i>Statistics Report ER OB</a></li>
                            <li><a href="{{ url('admin/average/user_online') }}"><i class="fa fa-certificate"></i>Average User's Online</a></li>
                            <li><a href="{{ url('admin/css') }}"><i class="fa fa-certificate"></i>CSS</a></li>
                        </ul>
                    </li>
                    <li class="dropdown" style="float:right">
                    <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bell"></i> <small class="badge bg-red" style="margin-bottom:5px;">{{ $notif }} </small>  </a>
                        <ul class="dropdown-menu dropdown-left-manual">
                                @foreach($data as $dat)
                                    @if($dat->now >= "34")
                                        @if($dat->notif == 1)
                                        <li>
                                            <a href="{{ url('doctor/aog/weeks/'.$dat->patient_code) }}" style="color: white;background-color: green;"><i class="fas fa-baby"></i> {{ $dat->woman_name }}
                                                <br><span> Current AOG {{$dat->now}} </span>
                                            </a>
                                        </li>
                                        @else
                                        <li>
                                            <a href="{{ url('doctor/aog/weeks/'.$dat->patient_code) }}" ><i class="fas fa-baby"></i> {{ $dat->woman_name }}
                                                <br><span> Current AOG {{$dat->now}} </span>
                                            </a>
                                        </li>
                                        @endif
                                    @endif
                                @endforeach
                            <!--
                        <li><a href="{{ url('admin/report/graph/bar_chart') }}"><i class="fa fa-bar-chart-o"></i>Graph</a></li>
                        -->
                        </ul>
                </li>
                @elseif($user->level=='billing')
                <li><a href="{{ url('billing/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="{{ url('doctor/accepted') }}"><i class="fa fa-user-plus"></i> Accepted Patients</a></li>
                @elseif($user->level=='support')
                <li><a href="{{ url('support/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="{{ url('support/users') }}"><i class="fa fa-user-md"></i> Manage Users</a></li>
                <li><a href="{{ url('support/hospital') }}"><i class="fa fa-hospital-o"></i> Hospital Info</a></li>
                <!-- <li><a href="{{ url('bed').'/'.$user->facility_id }}"><i class="fa fa-bed"></i> Update Bed Availability <small class="badge bg-red"> New</small></a></li> -->
                <!--
                <li><a href="{{ url('inventory').'/'.$user->facility_id }}"><i class="fa fa-calculator"></i> Inventory <span class="badge bg-red"> New</span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Reports
                        @if($count>0)
                            <span class="badge">
                        <span class="count_referral">{{ $count }}</span>
                    </span>
                        @endif
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('support/report/users') }}"><i class="fa fa-users"></i>Daily Users</a></li>
                        <li><a href="{{ url('support/report/referral') }}"><i class="fa fa-wheelchair"></i>Daily Referrals</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('support/report/incoming') }}"><i class="fa fa-ambulance"></i>Incoming Referral
                                @if($count>0)
                                    <span class="badge">
                                    <span class="count_referral">{{ $count }}</span>
                                </span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('support/chat') }}">
                                <i class="fa fa-comments"></i> IT Support: Group Chat
                            </a>
                        </li>
                    </ul>
                </li>
                -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Report <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        
                        <li><a href="{{ url('admin/report/online') }}"><i class="fa fa-users"></i>Online Users</a></li>
                        <li><a href="{{ url('online/facility') }}"><i class="fa fa-hospital-o"></i>Online Facility</a></li>
                        <li><a href="{{ url('offline/facility') }}"><i class="fa fa-times-circle-o"></i>Offline Facility</a></li>
                        <li><a href="{{ url('onboard/facility') }}"><i class="fa fa-ambulance"></i>Onboard Facility</a></li>
                        <li><a href="{{ url('onboard/users') }}"><i class="fa fa-ambulance"></i>Onboard Users <span class="badge bg-red">New</span></a></li>
                        <li><a href="{{ url('weekly/report') }}"><i class="fa fa-calendar-check-o"></i>Login Status <span class="badge bg-red">New</span></a></li>
                    <!--
                        <li><a href="{{ url('admin/report/referral') }}"><i class="fa fa-line-chart"></i>Referral Status</a></li>
                        <li><a href="{{ url('admin/daily/users') }}"><i class="fa fa-users"></i>Daily Users</a></li>
                        <li><a href="{{ url('admin/daily/referral') }}"><i class="fa fa-building"></i>Daily Hospital</a></li>
                        -->
                        <li><a href="{{ url('admin/report/consolidated/incomingv2') }}"><i class="fa fa-file-archive-o"></i>Consolidated</a></li>
                        <li><a href="{{ url('admin/statistics/incoming') }}"><i class="fa fa-certificate"></i>Statistics Report Incoming</a></li>
                        <li><a href="{{ url('admin/statistics/outgoing') }}"><i class="fa fa-certificate"></i>Statistics Report Outgoing</a></li>
                        <li><a href="{{ url('admin/er_ob') }}"><i class="fa fa-certificate"></i>Statistics Report ER OB</a></li>
                        <li><a href="{{ url('admin/average/user_online') }}"><i class="fa fa-certificate"></i>Average User's Online</a></li>
                    </ul>
                </li>
                @elseif($user->level=='mcc')
                <li><a href="{{ url('mcc/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                <!--
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Report <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('mcc/report/online') }}" data-toggle="modal"><i class="fa fa-users"></i> Online Department</a></li>
                        <li><a href="{{ url('mcc/report/incoming') }}" data-toggle="modal"><i class="fa fa-line-chart"></i> Incoming Referral</a></li>
                        <li><a href="{{ url('mcc/report/timeframe') }}" data-toggle="modal"><i class="fa fa-calendar"></i> Referral Time Frame</a></li>
                        <li><a tabindex="-1" href="{{ url('admin/report/consolidated/incomingv2') }}"><i class="fa fa-file-archive-o"></i> Consolidated</a></li>
                    </ul>
                </li>
                -->
                <li><a href="{{ url('mcc/track') }}"><i class="fa fa-line-chart"></i> Track</a></li>
                @elseif($user->level != 'billing' && $user->level != 'admin')
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Report <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        
                        <li><a href="{{ url('admin/report/online') }}"><i class="fa fa-users"></i>Online Users</a></li>
                        <li><a href="{{ url('online/facility') }}"><i class="fa fa-hospital-o"></i>Online Facility</a></li>
                        <li><a href="{{ url('offline/facility') }}"><i class="fa fa-times-circle-o"></i>Offline Facility</a></li>
                        <li><a href="{{ url('onboard/facility') }}"><i class="fa fa-ambulance"></i>Onboard Facility</a></li>
                    <!--
                        <li><a href="{{ url('admin/report/referral') }}"><i class="fa fa-line-chart"></i>Referral Status</a></li>
                        <li><a href="{{ url('admin/daily/users') }}"><i class="fa fa-users"></i>Daily Users</a></li>
                        <li><a href="{{ url('admin/daily/referral') }}"><i class="fa fa-building"></i>Daily Hospital</a></li>
                        -->
                        <li><a href="{{ url('admin/report/consolidated/incomingv2') }}"><i class="fa fa-file-archive-o"></i>Consolidated</a></li>
                        <li><a href="{{ url('admin/statistics/incoming') }}"><i class="fa fa-certificate"></i>Statistics Report Incoming</a></li>
                        <li><a href="{{ url('admin/statistics/outgoing') }}"><i class="fa fa-certificate"></i>Statistics Report Outgoing</a></li>
                        <li><a href="{{ url('admin/er_ob') }}"><i class="fa fa-certificate"></i>Statistics Report ER OB</a></li>
                        <li><a href="{{ url('admin/average/user_online') }}"><i class="fa fa-certificate"></i>Average User's Online</a></li>
                    

               
                    </ul>
                </li>
                @elseif($user->level=='admin')
                <li><a href="{{ url('admin/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ambulance"></i> E-Referral <span class="badge bg-red"> New</span><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('doctor/patient') }}"><i class="fa fa-table"></i> List of Patients</a></li>
                        <li><a href="{{ url('doctor/referred') }}"><i class="fa fa-ambulance"></i> Referred Patients</a></li>
                        <li><a href="{{ url('doctor/referred/track') }}"><i class="fa fa-line-chart"></i> Track Patient</a></li>
                    </ul>
                </li>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ambulance"></i> Diagnosis <span class="badge bg-red"> New</span><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('admin/maincat') }}"><i class="fa fa-table"></i> Main Category</a></li>
                        <li><a href="{{ url('admin/subcat') }}"><i class="fa fa-ambulance"></i> Sub Category</a></li>
                        <li><a href="{{ url('admin/diagnosis') }}"><i class="fa fa-line-chart"></i> Diagnosis</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-phone"></i> Call <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('opcen/client') }}"><i class="fa fa-phone"></i> Call Center</a></li>
                        <li><a href="{{ url('it/client') }}"><i class="fa fa-phone"></i> IT</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i> Manage <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('admin/users') }}" ><i class="fa fa-users"></i> IT Support/ Call Center/ Bed</a></li>
                        <li><a href="{{ url('admin/filetypes') }}" ><i class="fa fa-hospital-o"></i>&nbsp; File types</a></li>
                        <li><a href="{{ url('admin/facility') }}" ><i class="fa fa-hospital-o"></i>&nbsp; Facilities</a></li>
                        <li><a href="{{ url('admin/incident_type') }}" ><i class="fa fa-hospital-o"></i>&nbsp; Incident Type</a></li>
                        <li><a href="{{ url('admin/province') }}" ><i class="fa fa-hospital-o"></i>&nbsp; Province</a></li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="nav-label"><i class="fa fa-hospital-o"></i>&nbsp;&nbsp;&nbsp; Municipality</span></a>
                            <ul class="dropdown-menu">
                                @foreach(\App\Province::get() as $prov)
                                    <li><a href="{{ asset('admin/municipality').'/'.$prov->id }}">{{ $prov->description }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
             
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Report <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="{{ url('admin/report/graph/bar_chart') }}"><i class="fa fa-bar-chart-o"></i>Graph</a></li>
                        <li><a href="{{ url('admin/aog/weeks/report') }}"><i class="fas fa-baby"></i> 34 Weeks above</a></li>
                        <li><a href="{{ url('admin/pregnancy') }}"><i class="fa fa-building"></i></i>Facility Pregnancy</a></li>
                        <li><a href="{{ url('admin/report/online') }}"><i class="fa fa-users"></i>Online Users</a></li>
                        <li><a href="{{ url('online/facility') }}"><i class="fa fa-hospital-o"></i>Online Facility</a></li>
                        <li><a href="{{ url('offline/facility') }}"><i class="fa fa-times-circle-o"></i>Offline Facility</a></li>
                        <li><a href="{{ url('weekly/report') }}"><i class="fa fa-calendar-check-o"></i>Login Status</a></li>
                        <li><a href="{{ url('onboard/facility') }}"><i class="fa fa-ambulance"></i>Onboard Facility</a></li>
                        <li><a href="{{ url('onboard/users') }}"><i class="fa fa-ambulance"></i>Onboard Users</a></li>
                        <li><a href="{{ url('admin/report/referral') }}"><i class="fa fa-line-chart"></i>Referral Status</a></li>
                        <li><a href="{{ url('admin/daily/users') }}"><i class="fa fa-users"></i>Daily Users</a></li>
                        <li><a href="{{ url('admin/daily/referral') }}"><i class="fa fa-building"></i>Daily Hospital</a></li>
                        <li><a href="{{ url('admin/report/consolidated/incomingv2') }}"><i class="fa fa-file-archive-o"></i>Consolidated</a></li>
                        <li><a href="{{ url('admin/statistics/incoming') }}"><i class="fa fa-certificate"></i>Statistics Report Incoming</a></li>
                        <li><a href="{{ url('admin/statistics/outgoing') }}"><i class="fa fa-certificate"></i>Statistics Report Outgoing</a></li>
                        <li><a href="{{ url('admin/er_ob') }}"><i class="fa fa-certificate"></i>Statistics Report ER OB</a></li>
                        <li><a href="{{ url('admin/average/user_online') }}"><i class="fa fa-certificate"></i>Average User's Online</a></li>
                    <!--
                <li><a href="{{ url('admin/report/graph/bar_chart') }}"><i class="fa fa-bar-chart-o"></i>Graph</a></li>
                -->
                    </ul>
                </li>
                
                <li><a href="{{ url('excel/import') }}"><i class="fa fa-file-excel-o"></i> Import</a></li>
                @elseif($user->level=='eoc_region')
                <li><a href="{{ url('eoc_region/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="{{ url('eoc_city/graph') }}"><i class="fa fa-line-chart"></i> Graph</a></li>
                @elseif($user->level=='eoc_city')
                <li><a href="{{ url('eoc_city/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="{{ url('eoc_city/graph') }}"><i class="fa fa-line-chart"></i> Graph</a></li>
                @elseif($user->level=='opcen')
                    <li><a href="{{ url('opcen') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li><a href="{{ url('opcen/client') }}"><i class="fa fa-phone"></i> Call</a></li>
                    <li><a href="{{ asset('public/directory/Call-Center-Directory.xlsx') }}"><i class="fa fa-print"></i> Directory</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ambulance"></i> E-Referral <span class="badge bg-red"> New</span><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('doctor/patient') }}"><i class="fa fa-table"></i> List of Patients</a></li>
                            <li><a href="{{ url('doctor/referred') }}"><i class="fa fa-ambulance"></i> Referred Patients</a></li>
                            <li><a href="{{ url('doctor/referred/track') }}"><i class="fa fa-line-chart"></i> Track Patient</a></li>
                        </ul>
                    </li>
                @elseif($user->level == 'bed_tracker')
                    <li><a href="{{ url('bed_tracker') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <!-- <li><a href="{{ url('bed').'/'.$user->facility_id }}"><i class="fa fa-bed"></i> Update Bed Availability <small class="badge bg-red"> New</small></a></li> -->
                @elseif($user->level == 'monitoring')
                <li><a href="{{ url('monitor') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Report <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('monitoring/consolidated') }}"><i class="fa fa-file-archive-o"></i>Consolidated</a></li>
                            <li><a href="{{ url('monitoring/report/referral') }}"><i class="fa fa-line-chart"></i>Referral Status</a></li>
                            <li><a href="{{ url('monitoring/statistics/incoming') }}"><i class="fa fa-certificate"></i>Statistics Report Incoming</a></li>
                            <li><a href="{{ url('monitoring/statistics/outgoing') }}"><i class="fa fa-certificate"></i>Statistics Report Outgoing</a></li>
                            <li><a href="{{ url('monitoring/patient_transactions') }}"><i class="fa fa-certificate"></i>Patient Transactions</a></li>
                            <li><a href="{{ url('monitoring/login-status') }}"><i class="fa fa-calendar-check-o"></i>Login Status <span class="badge bg-red">New</span></a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('monitoring/list') }}"><i class="fa fa-user-md"></i> Who's Online</a></li>
                @elseif($user->level=='vaccine')
                    <li><a href="{{ url('vaccine') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    @foreach(\App\Province::get() as $prov)
                        <li><a href="{{ asset('vaccine/vaccineview').'/'.$prov->id }}">{{ $prov->description }}</a></li>
                    @endforeach
                    <li><a href="{{ asset('vaccine/facility').'/cebu' }}">Cebu City</a></li>
                    <li><a href="{{ asset('vaccine/facility').'/mandaue' }}">Mandaue City</a></li>
                    <li><a href="{{ asset('vaccine/facility').'/lapu' }}">Lapu-Lapu City</a></li>
                @endif
                @if($user->level == 'admin')
                    <li><a href="{{ url('admin/login') }}"><i class="fa fa-sign-in"></i> Login As</a></li>
                @endif

                @if($user->level != 'vaccine' && $user->level != 'monitoring' && $user->level != 'billing')
                <li><a href="{{ asset('public/manual/SeHRS-User-Manual.pdf') }}" target="_blank"><i class="fa fa-file-pdf-o"></i> E-REFERRAL Manual <small class="badge bg-red"> New</small></a></li>
                <!-- <li><a href="{{ url('bed_admin') }}"><i class="fa fa-bed"></i> Bed Availability Status <small class="badge bg-red"> New</small></a></li> -->
                <li><a href="{{ url('doctor/recotored') }}"><i class="fa fa-odnoklassniki"></i> Recommend to Redirect Patients Monitoring <small class="badge bg-red"> New</small></a></li>
                <li><a href="{{ url('patient/walkin') }}"><i class="fa fa-odnoklassniki"></i> Walk-in Patients Monitoring <small class="badge bg-red"> New</small></a></li>
                <li><a href="{{ url('monitoring') }}"><i class="fa fa-clock-o"></i> NOT ACCEPTED within 30 minutes <small class="badge bg-red"> New</small></a></li>
                <!-- <li><a href="{{ url('issue/concern') }}"><i class="fa fa fa-exclamation-triangle"></i> Issues and Concerns <small class="badge bg-red"> New</small></a></li> -->
                <li><a href="{{ url('chat') }}"><i class="fa fa-wechat"></i> Chat <span class="badge bg-green"><span>{{ $count_chat }}</span> New</span></a></li>
                @endif
                @if($user->level != 'monitoring' && $user->level != 'billing')
                <li><a href="{{ url('doctor/list') }}"><i class="fa fa-user-md"></i> Who's Online</a></li>
                @endif
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-gear"></i> Settings <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if($user->level == 'opcen')
                            <li><a href="{{ url('admin/login') }}"><i class="fa fa-sign-in"></i> Login As <small class="badge bg-red"> New</small></a></li>
                        @endif
                        <li><a href="#setLogoutTime" data-toggle="modal" onclick="openLogoutTime();"><i class="fa fa-clock-o"></i> Set Time to Logout</a></li>
                        <li><a href="#resetPasswordModal" data-toggle="modal"><i class="fa fa-key"></i> Change Password</a></li>
                        @if($user->level=='doctor' || $user->level=='midwife')
                            <li><a href="#dutyModal" data-toggle="modal"><i class="fa fa-user-md"></i> Change Login Status</a></li>
                            <li class="divider"></li>
                            <li><a href="#loginModal" data-toggle="modal"><i class="fa fa-users"></i> Switch User</a></li>
                        @else
                            <li class="divider"></li>
                        @endif
                        <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
                        @if(Session::get('admin'))
                            <?php
                                $check_login_as = \App\User::find($user->id);
                            ?>
                            <li><a href="{{ url('admin/account/return') }}"><i class="fa fa-user-secret"></i> <?php echo $check_login_as->level == 'admin' ? 'Back as Admin' : 'Back as Agent'; ?></a></li>
                        @endif
                    </ul>
                </li>
                
               
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>


    @if(isset(Request::segments()[3]))
        <div class="{{ in_array(Request::segments()[0].'/'.Request::segments()[1].'/'.Request::segments()[2].'/'.Request::segments()[3], array('admin/report/patient/incoming','admin/report/patient/outgoing','admin/report/consolidated/incoming','admin/report/graph/incoming','admin/report/consolidated/incomingv2','admin/report/graph/bar_chart'), true)
            ? 'container-fluid' : 'container' }}" >
            <div class="loading"></div>
            @yield('content')
            <div class="clearfix"></div>
        </div> <!-- /container -->
    @elseif(isset(Request::segments()[2]))
        <div class="{{ in_array(Request::segments()[0].'/'.Request::segments()[1].'/'.Request::segments()[2], array('vaccine/vaccineview/1','vaccine/vaccineview/2','vaccine/vaccineview/3','vaccine/vaccineview/4','vaccine/facility/cebu','vaccine/facility/mandaue','vaccine/facility/lapu'), true) ? 'container-fluid' : 'container' }}" >
            <div class="loading"></div>
            @yield('content')
            <div class="clearfix"></div>
        </div> <!-- /container -->
    @else
        <div class="{{ in_array(Request::segments()[0], array('vaccine'), true) ? 'container-fluid' : 'container' }}" id="container">
            <div class="loading"></div>
            <div class="row">
                @yield('content')
            </div>
            <div class="clearfix"></div>
        </div> <!-- /container -->
    @endif
</div>

@include('modal.server')
@include('modal.password')
@include('modal.duty')
@include('modal.login')
@include('modal.incoming')
@include('modal.license_no')


<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up"></i> Go Top</button>
<footer class="footer">
    <div class="container">
        <p class="pull-right">All Rights Reserved {{ date("Y") }} | Version 4.5</p>
    </div>
</footer>


<!-- Bootstrap core JavaScript
================================================== -->

<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('resources/assets/js/jquery.min.js?v='.date('mdHis')) }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('resources/plugin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

<script src="{{ asset('resources/assets/js/jquery.form.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/jquery-validate.js') }}"></script>
<script src="{{ asset('resources/assets/js/bootstrap.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('resources/assets/js/ie10-viewport-bug-workaround.js') }}"></script>
<script src="{{ asset('resources/assets/js/script.js') }}?v=1"></script>

<script src="{{ asset('resources/plugin/Lobibox/Lobibox.js') }}?v=1"></script>
<!-- <script src="{{ asset('resources/plugin/select2/select2.min.js') }}?v=1"></script> -->
<script src="{{ asset('resources/select2/dist/js/select2.min.js') }}?v=1"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('resources/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}?v=1"></script>

<script src="{{ url('resources/plugin/daterangepicker_old/moment.min.js') }}"></script>
<script src="{{ url('resources/plugin/daterangepicker_old/daterangepicker.js') }}"></script>

<script src="{{ asset('resources/assets/js/jquery.canvasjs.min.js') }}?v=1"></script>

<!-- TABLE-HEADER-FIXED -->
<script src="{{ asset('resources/plugin/table-fixed-header/table-fixed-header.js') }}"></script>
<!-- PUSHER -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(".select2").select2({ width: '100%' });

    var path_gif = "<?php echo asset('resources/img/loading.gif'); ?>";
    var loading = '<center><img src="'+path_gif+'" alt=""></center>';

    var urlParams = new URLSearchParams(window.location.search);
    var query_string_search = urlParams.get('search') ? urlParams.get('search') : '';
    var query_string_date_range = urlParams.get('date_range') ? urlParams.get('date_range') : '';
    var query_string_typeof_vaccine = urlParams.get('typeof_vaccine_filter') ? urlParams.get('typeof_vaccine_filter') : '';
    var query_string_muncity = urlParams.get('muncity_filter') ? urlParams.get('muncity_filter') : '';
    var query_string_facility = urlParams.get('facility_filter') ? urlParams.get('facility_filter') : '';
    var query_string_department = urlParams.get('department_filter') ? urlParams.get('department_filter') : '';
    var query_string_option = urlParams.get('option_filter') ? urlParams.get('option_filter') : '';


    console.log(location.protocol);

    $(".pagination").children().each(function(index){
        var _href = $($(this).children().get(0)).attr('href');

        if(_href){
           //_href = _href.replace("http",location.protocol);
            //console.log(_href);
            $($(this).children().get(0)).attr('href',_href+'&search='+query_string_search+'&date_range='+query_string_date_range+'&typeof_vaccine_filter='+query_string_typeof_vaccine+'&muncity_filter='+query_string_muncity+'&facility_filter='+query_string_facility+'&department_filter='+query_string_department+'&option_filter='+query_string_option);
        }

    });


    function refreshPage(){
        <?php
            use Illuminate\Support\Facades\Route;
            $current_route = Route::getFacadeRoot()->current()->uri();
        ?>
        $('.loading').show();
        window.location.replace("<?php echo asset($current_route) ?>");
    }

    function loadPage(){
        $('.loading').show();
    }

    function openLogoutTime(){
        var login_time = "<?php echo date('H:i'); ?>";
        var logout_time = "<?php echo date('H:i',strtotime($logout_time)); ?>";
        var input_element = $("#input_time_logout");
        input_element.attr({
            "min" : login_time
        });
        input_element.val(logout_time);
    }

    // Set the date we're counting down to
    var countDownDate = new Date("{{ $logout_time }}").getTime();
    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("logout_time").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("logout_time").innerHTML = "EXPIRED";
            window.location.replace("<?php echo asset('/logout') ?>");
        }
    }, 1000);

    @if(Session::get('logout_time'))
        Lobibox.notify('success', {
            title: "",
            msg: "Successfully set logout time",
            size: 'mini',
            rounded: true
        });
        <?php Session::put("logout_time",false); ?>
    @endif


    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        $('body,html').animate({
            scrollTop : 0 // Scroll to top of body
        }, 500);
    }

</script>
@include('script.license_no')
@include('script.firebase')
@include('script.newreferral')
@include('script.password')
@include('script.duty')
@include('script.desktop-notification')
@include('script.notification')

@yield('js')

</body>
</html>