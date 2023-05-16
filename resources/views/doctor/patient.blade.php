<?php
    $user = Session::get('auth');
?>

@extends('layouts.app')

@section('content')
    <style>
        .ui-autocomplete
        {
            background-color: white;
            width: 20%;
            z-index: 1100;
            max-height: 300px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
        }
        .ui-menu-item {
            cursor: pointer;
        }

        .modal-xl {
        width: 90%;
        margin: auto;
        }
        
        .pre_pregnancy_table td
        {
            width: 1%;
            text-align:center;
        }

        .pre_pregnancy_table th
        {
            text-align:center;
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

    </style>
    <div class="col-md-3">
        @include('sidebar.'.$sidebar)
    </div>
    <div class="col-md-9">
        <div class="jim-content">
            <h3 class="page-header">{{ $title }}</h3>
            @if(count($data))
                <div class="table-responsive">
                    <table class="table table-striped"  style="white-space:nowrap;">
                        <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Age / DOB</th>
                            <th>Barangay</th>
                            <th style="width:18%;">Action</th>
                        </tr>
                        @foreach($data as $row)
                        <?php
                            $modal = ($row->type=='normal') ? '#normalFormModal' : '#pregnantFormModal';
                        ?>
                        <tr>
                            <td>
                                <b>
                                    <a href="#patient_modal"
                                       data-toggle="modal"
                                       data-id = "{{ $row->id }}"
                                       onclick="PatientBody('<?php echo $row->id ?>')"
                                       class="update_info">
                                        {{ $row->lname }}, {{ $row->fname }} {{ $row->mname }}
                                    </a>
                                </b><br>
                                <small class="text-success">{{ $row->contact }}</small>
                            </td>
                            <td>
                                {{ $row->sex }}<br>
                                <small class="text-success">{{ $row->civil_status }}</small>
                            </td>
                            <td>
                                <?php $age = \App\Http\Controllers\ParamCtrl::getAge($row->dob);?>
                                {{ $age }} years old
                                <br />
                                <small class="text-muted">{{ date('M d, Y',strtotime($row->dob)) }}</small>
                            </td>
                            <td>
                                <?php
                                    $brgy_id = ($source=='tsekap') ? $row->barangay_id: $row->brgy;
                                    $city_id = ($source=='tsekap') ? $row->muncity_id: $row->muncity;
                                    $phic_id = ($source=='tsekap') ? $row->phicID: $row->phic_id;
                                    $phic_id_stat = 0;
                                    if($phic_id){
                                        $phic_id_stat = 1;
                                    }
                                ?>
                                @if($brgy_id!=0)
                                {{ $brgy = \App\Barangay::find($brgy_id)->description }}<br />
                                <small class="text-success">{{ $city = \App\Muncity::find($city_id)->description }}</small>
                                @else
                                    {{ $row->address }}
                                @endif
                            </td>
                            <td>
                                @if($row->sex=='Female' && ($age >= 10 && $age <= 49))
                                    <a href="#pregnantModal"
                                       data-patient_id = "{{ $row->id }}"
                                       data-toggle="modal"
                                       class="btn btn-primary btn-xs profile_info hide btn_refer_preg">
                                        <i class="fa fa-stethoscope"></i>
                                        Refer
                                    </a>
                                    <a href="#pregnantModalWalkIn"
                                       data-patient_id = "{{ $row->id }}"
                                       data-toggle="modal"
                                       class="btn btn-warning btn-xs profile_info hide">
                                        <i class="fa fa-ambulance"></i>
                                        Walk-In
                                    </a>
                                @else
                                    <a href="#normalFormModal"
                                       data-patient_id = "{{ $row->id }}"
                                       data-backdrop="static"
                                       data-toggle="modal"
                                       class="btn btn-primary btn-xs profile_info hide">
                                        <i class="fa fa-stethoscope"></i>
                                        Refer
                                    </a>
                                    <a href="#normalFormModalWalkIn"
                                       data-patient_id = "{{ $row->id }}"
                                       data-backdrop="static"
                                       data-toggle="modal"
                                       class="btn btn-warning btn-xs profile_info hide">
                                        <i class="fa fa-ambulance"></i>
                                        Walk-In
                                    </a>
                                @endif
                                   <!-- <a href="#vital_modal"
                                      onclick="VitalBody('<?php echo $row->id ?>')"
                                       data-patient_id = "{{ $row->id }}"
                                       data-backdrop="static"
                                       data-toggle="modal"
                                       class="btn btn-success btn-xs vital_info hide">
                                        <i class="fa fa-plus"></i>
                                        V.S / P.E
                                    </a> -->
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $data->links() }}
                </ul>

            @else
                <div class="alert alert-warning">
                <span class="text-warning">
                    <i class="fa fa-warning"></i> Patient not found!
                </span>
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
    @include('modal.pregnantModal')
    @include('modal.pregnant_modal_track')
    @include('modal.normal_form_editable')
    @include('modal.normal_form_editable_walkin')
    @include('modal.pregnant_form_editable')
    @include('modal.pregnant_form_editable_walkin')
    @include('modal.addvital')
    @include('modal.pexam')
@endsection

@section('js')
@include('script.filterMuncity')
@include('script.firebase')
@include('script.datetime')
@include('script.patient_script')
@include('script.pregnant_modal')
@endsection

