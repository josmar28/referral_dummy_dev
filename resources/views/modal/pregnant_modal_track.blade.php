<?php
    $user = Session::get('auth');
    $myfacility = \App\Facility::find($user->facility_id);
    $facilities = \App\Facility::select('id','name')
        ->where('id','!=',$user->facility_id)
        ->where('status',1)
        ->where('referral_used','yes')
        ->orderBy('name','asc')->get();
?>
<div class="modal fade" role="dialog" id="pregnantFormModalTrack">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="POST" class="form-submit" action="{{ url('doctor/patient/refer/pregnant') }}" id="pregnant_form_new" >
            <div class="jim-content">
                @include('include.header_form')
                <div class="title-form">Risk Assessment Check list for Pregnant Women</div>
                {{ csrf_field() }}
                    <input type="hidden" name="patient_id" class="patient_id" value="" />
                    <input type="hidden" name="date_referred" class="date_referred" value="{{ date('Y-m-d H:i:s') }}" />
                    <input type="hidden" name="code" value="" />
                    <input type="hidden" name="source" value="{{ $source }}" />
                    <input type="hidden" name="referring_name" value="{{ $myfacility->name }}" />
                    <input type="hidden" name="referring_facility" value="{{ $myfacility->id }}" />
                    <div class="row">

                    <div class="row">
                        <div class="col-md-4">
                            Referred to:
                                <select name="referred_facility" class="form-control-select select2 select_facility" style="width: 100%" required>
                                <option value="">Select Facility...</option>
                                    @foreach($facilities as $row)
                                          <option data-name="{{ $row->name }}" value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                        </div>

                        <div class="col-md-4">
                        Department:
                                <select name="referred_department" class="form-control select_department select_department_pregnant" required>
                                    <option value="">Select Department...</option>
                                </select>
                        </div>

                        <div class="col-md-4">
                            Address:
                            <span class="text-primary facility_address"></span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4 mt-2">
                            Pregnant Status:
                                <select name="pregnant_status" class="form-control-select select2" style="width: 100%" required>
                                <option value="">Select Status...</option>
                                <option value="moderate">Moderate</option>
                                <option value="highrisk">High risk</option>
                                </select>
                        </div>

                     
                    </div>

                        <h2>Patients Information</h2>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Personnal Data</a></li>
                            <li><a data-toggle="tab" href="#menu1">Antepartum Conditions</a></li>
                            <li><a data-toggle="tab" href="#menu2">Sign and Symptoms</a></li>
                            <li><a data-toggle="tab" href="#menu3">Lab Result</a></li>
                            <!-- <li><a data-toggle="tab" href="#menu4">Vital Signs</a></li> -->
                            <!-- <li><a data-toggle="tab" href="#menu5">Pregnancy Outcome</a></li> -->
                        </ul>

                        <div class="tab-content">

                            <div id="home" class="tab-pane fade in active">
                                    <table class="table table-striped">
                                        <tr class="bg-gray">
                                            <th colspan="5">A.I Personnal Data</th>
                                        </tr>
                                        <tr>
                                            <td width="25%">Referring Facility: <span class="text-primary">{{ $myfacility->name }} </td>
                                            <td width="25%">Address of facility: <span class="text-primary">{{ $myfacility->address }}</span> </td>
                                            <td width="25%" >PHIC: <span class="text-primary phic_id"></span> </td>
                                            <td width="25%" colspan="4">Referred Date: <span class="text-primary">{{ date('l M d, Y') }}</span> </td>
                           
                                        </tr>
                                        <tr>
                                            <td >Name of Patient: <span class="text-primary patient_name"></span> </td>
                                            <td>Age: <span class="text-primary patient_age"></span> </td>
                                            <td>Sex: <span class="text-primary preg_patient_sex"></span> </td>
                                            <td>
                                                Educational Attainment:
                                                    <select name="educ_attainment" class="form-control educ_attainment" required>
                                                        <option value="">Select Attainment...</option>
                                                        <option value="elementary">Elementary</option>
                                                        <option value="highschool">Highschool</option>
                                                        <option value="college">College</option>
                                                    </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address of Patient: <span class="text-primary patient_address"></span> </td>
                                            <td>Birthday: <span class="text-primary patient_dob"></span></td>
                                            <td>Marital Status: <span class="text-primary preg_civil_status"></span> </td>
                                            <td>
                                                Family Monthly Income:
                                                    <select name="family_income" class="form-control family_income" required>
                                                        <option value="">Select Income...</option>
                                                        <option value="rich"> 219,140</option>
                                                        <option value="high">131,484 - 219,140</option>
                                                        <option value="upper_middle">76,670 - 131,483</option>
                                                        <option value="middle">43,829 - 76,669</option>
                                                        <option value="lower_middle">21,915 - 43,828</option>
                                                        <option value="low">10,958 - 21,914</option>
                                                        <option value="poor"><10,957</option>
                                                    </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Contact No. of Patient: <span class="text-primary patient_contact"></span> </td>
                                            <td>Religion: <input type="text" class="form-control religion" name="religion" style="width: 100%;"> </td>
                                            <td>Ethnicity: <input type="text" class="form-control ethnicity" name="ethnicity" style="width: 100%;"> </td>
                                            <td>Sibling Rank: 
                                                <input type="text" class="form-control sibling_rank" name="sibling_rank" style="width: 100%;"> Out of  
                                                <input type="text" class="form-control out_of" name="out_of" style="width: 100%;"> 
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="table table-striped">
                                        <tr class="bg-gray">
                                            <th colspan="6">A.II Personnal Data</th>
                                        </tr>
                                        <tr>
                                            <td>Gravidity: <input type="text" class="form-control gravidity" name="gravidity" style="width: 100%;"> </td>
                                            <td>Parity: <input type="text" class="form-control parity" name="parity" style="width: 100%;"> </td>
                                            <td>Height (m): <input type="text" class="form-control height" name="height" style="width: 100%;"> </td>
                                            <td>Weigth (kg): <input type="text" class="form-control weigth"  id="new_refer_weigth"  name="weigth" style="width: 100%;"></td>
                                            <td>Fundic Height: <input type="text" class="form-control fh_personnal" name="fundic_height" style="width: 100%;"> </td>
                                            <td>HR: <input type="text" class="form-control hr_personnal" name="hr" style="width: 100%;"></td>
                                        </tr>
                                        <tr>
                                            <td>LMP: <input type="text" class="form-control new_refer_lmp_date" name="lmp" placeholder="mm/dd/yyyy" style="width: 100%;">  </td>
                                            <td>EDC/EDD: <input type="text" id="edc_edd" class="form-control edc_edd" name="edc_edd" placeholder="mm/dd/yyyy" style="width: 100%;" readonly> </td>
                                            <td>FTPAL: <input type="text" class="form-control ftpal" name="ftpal" style="width: 100%;"> </td>
                                            <td>BMI: <input type="text"class="form-control bmi" id="new_refer_bmi" name="bmi" style="width: 100%;"> </td>
                                            <td>BP: <input type="text" class="form-control bp_personnal" name="bp" style="width: 100%;"></td>
                                            <td>TEMP: <input type="text" class="form-control temp_personnal" name="temp" style="width: 100%;"></td>
                                        </tr>
                                        <tr>
                                            <td>RR: <input type="text" class="form-control rr_personnal" name="rr" style="width: 100%;"></td>
                                            <td>Td1: <input type="text" placeholder="mm/dd/yyyy" class="form-control td1" name="td1" style="width: 100%;"></td>
                                            <td>Td2: <input type="text" placeholder="mm/dd/yyyy" class="form-control td2" name="td2" style="width: 100%;"> </td>
                                            <td>Td3: <input type="text" placeholder="mm/dd/yyyy" class="form-control td3" name="td3" style="width: 100%;"> </td>
                                            <td>Td4: <input type="text" placeholder="mm/dd/yyyy" class="form-control td4" name="td4" style="width: 100%;"> </td>
                                            <td>Td5: <input type="text" placeholder="mm/dd/yyyy" class="form-control td5" name="td5" style="width: 100%;"> </td>
                                        </tr>
                                    </table>
                            </div>

                            <div id="menu1" class="tab-pane fade">
                                   <table class="table table-striped pre_pregnancy_table">
                                        <tr class="bg-gray">
                                            <th>Risk Factor</th>
                                            <th>Risk Factor</th>
                                            <th>Risk Factor</th>
                                            <th>Risk Factor</th>
                                            <th>Risk Factor</th>
                                            <th>Remarks/Management</th>
                                        </tr>
                                        <tr>
                                            <td> Hypertension <br> <input type="checkbox" value="yes" class="hypertension" name="hypertension"></td>
                                            <td> Anemia <br> <input type="checkbox" value="yes" class="anemia" name="anemia"></td>
                                            <td> Malaria <br> <input type="checkbox" value="yes" class="malaria" name="malaria"></td>
                                            <td> Cancer <br> <input type="checkbox" value="yes" class="cancer" name="cancer"></td>
                                            <td> Allergies <br> <input type="checkbox" value="yes" class="allergies" name="allergies"></td>
                                            <td rowspan="5"> 

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <small class="text-info">Subjective</small><br>
                                                       <textarea class="form-control new_ante_subjective" name="ante_subjective" style="resize: none;width: 100%;"> </textarea>
                                                    </div>
                                                </div>    

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small class="text-info">BP</small><br>
                                                        <input type="text" class="form-control bp_antepartum"  name="ante_bp" style="width: 100%;">
                                                        <small class="text-info">HR</small><br>
                                                        <input type="text" class="form-control hr_antepartum"  name="ante_hr" style="width: 100%;">
                                                        <small class="text-info">FH</small><br>
                                                        <input type="text" class="form-control fh_antepartum"  name="ante_fh" style="width: 100%;">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <small class="text-info">TEMP</small><br>
                                                         <input type="text" class="form-control temp_antepartum"  name="ante_temp" style="width: 100%;">
                                                        <small class="text-info">RR</small><br>
                                                         <input type="text" class="form-control rr_antepartum"  name="ante_rr" style="width: 100%;">
                                                        <small class="text-info">FHT</small><br>
                                                         <input type="text" class="form-control antepartum_fht"  name="ante_fht" style="width: 100%;">
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <small class="text-info">Other Physical Examination</small><br>
                                                       <textarea class="form-control new_ante_other_physical_exam" name="ante_other_physical_exam" style="resize: none;width: 100%;"> </textarea>
                                                    </div>
                                                </div> 

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <small class="text-info">Assessment/Diagnosis</small><br>
                                                       <textarea class="form-control new_ante_assessment_diagnosis" name="ante_assessment_diagnosis" style="resize: none;width: 100%;"> </textarea>
                                                    </div>
                                                </div> 

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <small class="text-info">Plan/Intervention</small><br>
                                                       <textarea class="form-control new_ante_plan_intervention" name="ante_plan_intervention" style="resize: none;width: 100%;"> </textarea>
                                                    </div>
                                                </div> 

                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Renal Disease<br> <input type="checkbox" value="yes" class="renal_disease" name="renal_disease"></</td>
                                            <td> Typhoid Disorders <br> <input type="checkbox" value="yes" class="typhoid_disorders" name="typhoid_disorders"></td>
                                            <td> Hypo/Hyperthyroidism <br> <input type="checkbox" value="yes" class="hypo_hyperthyroidism" name="hypo_hyper"></td>
                                            <td> Tuberculosis <br> <input type="checkbox" value="yes" class="tuberculosis" name="tuberculosis"></td>
                                            <td> Diabetes Mellitus <br> <input type="checkbox" value="yes" class="diabetes_mellitus" name="diabetes_mellitus"></td>
                                        </tr>
                                        <tr>
                                            <td> Hepatitis B Infection<br> <input type="checkbox" value="yes" class="hepatitisb_infection" name="hepatatis_b"></</td>
                                            <td> HIV-AIDs/STI <br> <input type="checkbox" value="yes" class="hiv_sti" name="hiv_sti"></td>
                                            <td> Seizure Disorder <br> <input type="checkbox" value="yes" class="seizure_disorder" name="seizure_disorder"></td>
                                            <td> Cardiovascular disease <br> <input type="checkbox" value="yes" class="cardiovascular_disease" name="cardiovascular_disease"></td>
                                            <td> Malnutrition (<18.5 BMI) <br> <input type="checkbox" value="yes" class="malnutrition" name="malnutrition"></td>
                                        </tr>
                                        <tr>
                                            <td> Hemotilgic/Bleeding disorder<br> <input type="checkbox" value="yes" class="hemotilgic_bleeding" name="hemotilgic_disorder"></td>
                                            <td> Alcohol/Substance Abuse <br> <input type="checkbox" value="yes" class="alcohol_abuse" name="substance_abuse"></td>
                                            <td> Patient w/ anti-phospholipid syndrome <br> <input type="checkbox" value="yes" class="phospholipid_syndrome" name="anti_phospholipid"></td>
                                            <td> Obstructive or restrictive pulmonary disease (Asthma) <br> <input type="checkbox" value="yes" class="asthma" name="restrictive_pulmonary"></td>
                                            <td> Patients w/psychiatirc conditions and/mental retardation <br> <input type="checkbox" value="yes" class="psychiatric_mental" name="mental_retardation"></td>
                                        </tr>
                                        <tr>
                                            <td> Habitual abortion (2 consecutive abortion and 3/more repeated abortion)<br> <input type="checkbox" value="yes" class="habitual_abortion" name="habitual_abortion"></td>
                                            <td> Birth of fetus with congenital anomaly <br> <input type="checkbox" value="yes" class="fetus_congenital" name="fetus_congenital"></td>
                                            <td> Previous caesarean section <br> <input type="checkbox" value="yes" class="previous_caesarean" name="previous_caesarean"></td>
                                            <td> Preterm Delivery resulting to stillbirth or neonatal death <br> <input type="checkbox" value="yes" class="neonatal_death" name="preterm_delivery"></td>
                                            <td>
                                                <small class="text-info">Others</small><br>
                                                <textarea class="form-control new_others" name="others" style="resize: none;width: 100%;"> </textarea> 
                                            </td>
                                        </tr>
                                    </table>
                            </div>

                            <div id="menu2" class="tab-pane fade">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#previous">New Data</a></li>
                                        <!-- <li><a data-toggle="tab" href="#current">Previous Data</a></li> -->
                                    </ul>

                                    <div class="tab-content">
                                                    <div id="previous" class="tab-pane fade in active">
                                                        <table class="table table-striped sign_symthoms_table">
                                                                <tr class="bg-gray">
                                                                    <th rowspan="4" width="50%"> 
                                                                        <br><br><br><br><br><h3>Risk Factor</h3>
                                                                            (a CHECK to ATLEAST ONE of the boxex indicates REFERRAL to a higher facility) 
                                                                    </th>
                                                                    <th> 
                                                                        <span> 
                                                                            <select style="width:50px;" class="new_trimester" name="no_trimester" required readonly>
                                                                            <option style="width:150px;" value="">...</option>
                                                                            <option value="1st">1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            </select> Trimester 
                                                                        </span>
                                                                    </th>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> 
                                                                        <span> 
                                                                            <select style="width:50px;" name="no_visit" class="new_visit_no" required>
                                                                            <option style="width:150px;" value="" selected>...</option>
                                                                            <option value="1st" >1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            <option value="4th">4th</option>
                                                                            <option value="5th">5th</option>
                                                                            </select> Visit 
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> 
                                                                        <center>
                                                                            <span> Date: <input  class="form-control new_refer_date_of_visit" placeholder="mm/dd/yyyy" type="text" name="date_of_visit">  <br>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> <b>Remarks</b></td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="vaginal_spotting" name="vaginal_spotting" value="yes" stlye="float:left">Vaginal spotting or bleeding</td>
                                                                    <td rowspan="13">
                                                                        <center>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Subjective</small><br>
                                                                                    <textarea class="form-control" name="sign_subjective" style="resize: none;width: 100%;"> </textarea>
                                                                                </div>
                                                                            </div>    

                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <small class="text-info">AOG</small><br>
                                                                                    <input type="text" class="form-control new_aog"  name="sign_aog" style="width: 100%;" readonly>
                                                                                </div>

                                                                                <div class="col-md-4">

                                                                                </div>
                                                                            </div>    

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">BP</small><br>
                                                                                    <input type="text" class="form-control bp_signsymptoms"  name="sign_bp" style="width: 100%;">
                                                                                    <small class="text-info">HR</small><br>
                                                                                    <input type="text" class="form-control hr_signsymptoms"  name="sign_hr" style="width: 100%;">
                                                                                    <small class="text-info">FH</small><br>
                                                                                    <input type="text" class="form-control fh_signsymptoms"  name="sign_fh" style="width: 100%;">
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">TEMP</small><br>
                                                                                    <input type="text" class="form-control temp_signsymptoms"  name="sign_temp" style="width: 100%;">
                                                                                    <small class="text-info">RR</small><br>
                                                                                    <input type="text" class="form-control rr_signsymptoms"  name="sign_rr" style="width: 100%;">
                                                                                    <small class="text-info">FHT</small><br>
                                                                                    <input type="text" class="form-control fht_signsymptoms"  name="sign_fht" style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Other Physical Examination</small><br>
                                                                                <textarea class="form-control sign_other_physical_exam" id="sign_other_physical_exam" name="sign_other_physical_exam" style="resize: none;width: 100%;"></textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Assessment/Diagnosis</small><br>
                                                                                <textarea class="form-control sign_assessment_diagnosis" id="sign_assessment_diagnosis" name="sign_assessment_diagnosis" style="resize: none;width: 100%;"></textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Plan/Intervention</small><br>
                                                                                <textarea class="form-control" name="sign_plan_intervention" style="resize: none;width: 100%;"></textarea>
                                                                                </div>
                                                                            </div> 
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td><input type="checkbox" class="severe_nausea" value="yes" name="severe_nausea" stlye="float:left">Severe nausea and vomiting </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="significant_decline" value="yes" name="significant_decline" stlye="float:left">Significant decline fetal movement (less than 10 in 12 hrs during 2 ½ of pregnancy) </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="persistent_contractions" value="yes" name="persistent_contractions" stlye="float:left">Persistent contractions</td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="premature_rupture" value="yes" name="premature_rupture" stlye="float:left">Premature rupture of the bag of membrane </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="fetal_pregnancy" value="yes" name="fetal_pregnancy" stlye="float:left">Multi fetal pregnancy </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="severe_headache" value="yes" name="severe_headache" stlye="float:left">Persistent severe headache, dizziness, or blurring of vision </td>
                                                                    
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="abdominal_pain" value="yes" name="abdominal_pain" stlye="float:left">Abdominal pain or epigastric pain </td>
                                                                
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="edema_hands" value="yes" name="edema_hands" stlye="float:left">Edema of the hands, feet or face </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box"> 
                                                                    <td ><input type="checkbox" class="fever_pallor" value="yes" name="fever_pallor" stlye="float:left">Fever or pallor </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="seizure_consciousness" value="yes" name="seizure_consciousness" stlye="float:left">Seizure or loss of consciousness </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="difficulty_breathing" value="yes" name="difficulty_breathing" stlye="float:left">Difficulty of breathing </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="painful_urination" value="yes" name="painful_urination" stlye="float:left">Painful urination </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="elevated_bp" value="yes" name="elevated_bp" stlye="float:left">Elevated blood pressure ≥ 120/90 </td>
                                                                    
                                                                </tr>
                                                        </table>
                                                    </div>

                                                    <!-- <div id="current" class="tab-pane fade">
                                                        <table class="table table-striped sign_symthoms_table">
                                                                <tr class="bg-gray">
                                                                    <th rowspan="4" width="50%"> 
                                                                        <br><br><br><br><br><h3>Risk Factor</h3>
                                                                            (a CHECK to ATLEAST ONE of the boxex indicates REFERRAL to a higher facility) 
                                                                    </th>
                                                                    <th> 
                                                                        <span> 
                                                                            <select style="width:50px;" class="prev_trimester" disabled>
                                                                            <option styple="width:150px;" value="">...</option>
                                                                            <option value="1st">1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            </select> Trimester 
                                                                        </span>
                                                                    </th>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> 
                                                                        <span> 
                                                                            <select style="width:50px;" class="prev_visit" disabled>
                                                                            <option styple="width:150px;" value="">...</option>
                                                                            <option value="1st">1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            <option value="4th">4th</option>
                                                                            <option value="5th">5th</option>
                                                                            <option value="6th">6th</option>
                                                                            <option value="7th">7th</option>
                                                                            <option value="8th">8th</option>
                                                                            <option value="9th">9th</option>
                                                                            <option value="10th">10th</option>
                                                                            <option value="11th">11th</option>
                                                                            <option value="12th">12th</option>
                                                                            </select> Visit 
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> 
                                                                        <center>
                                                                            <span> Date: <input  class="form-control prev_date"  type="date" disabled>  <br>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> <b>Remarks</b></td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_viganal_bleeding" stlye="float:left" disabled>Vaginal spotting or bleeding</td>
                                                                    <td rowspan="13">
                                                                        <center>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Subjective</small><br>
                                                                                    <textarea class="form-control prev_subjective" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div>    


                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <small class="text-info">AOG</small><br>
                                                                                    <input type="text" class="form-control prev_aog" style="width: 100%;" disabled>
                                                                                </div>

                                                                                <div class="col-md-4">

                                                                                </div>
                                                                            </div>  

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">BP</small><br>
                                                                                    <input type="text" class="form-control prev_bp"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">HR</small><br>
                                                                                    <input type="text" class="form-control prev_hr"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">FH</small><br>
                                                                                    <input type="text" class="form-control prev_fh"  style="width: 100%;" disabled>
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">TEMP</small><br>
                                                                                    <input type="text" class="form-control prev_temp"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">RR</small><br>
                                                                                    <input type="text" class="form-control prev_rr"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">FHT</small><br>
                                                                                    <input type="text" class="form-control prev_fht"  style="width: 100%;" disabled>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Other Physical Examination</small><br>
                                                                                <textarea class="form-control prev_other_exam" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Assessment/Diagnosis</small><br>
                                                                                <textarea class="form-control prev_assestment_diagnosis" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Plan/Intervention</small><br>
                                                                                <textarea class="form-control prev_plan_intervention" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div> 
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_severe_nausea" stlye="float:left" disabled>Severe nausea and vomiting </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_significant_decline" stlye="float:left" disabled>Significant decline fetal movement (less than 10 in 12 hrs during 2 ½ of pregnancy) </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_persistent_contractions" stlye="float:left" disabled>Persistent contractions</td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_premature_rupture" stlye="float:left" disabled>Premature rupture of the bag of membrane </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_multi_pregnancy" stlye="float:left" disabled>Multi fetal pregnancy </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox"  class="prev_persistent_severe" stlye="float:left" disabled>Persistent severe headache, dizziness, or blurring of vision </td>
                                                                    
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_abdominal_pain" stlye="float:left" disabled>Abdominal pain or epigastric pain </td>
                                                                
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_edema_hands" stlye="float:left" disabled>Edema of the hands, feet or face </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box"> 
                                                                    <td ><input type="checkbox" class="prev_fever_pallor" stlye="float:left" disabled>Fever or pallor </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_seiszure_consciousness" stlye="float:left" disabled>Seizure or loss of consciousness </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_difficulty_breathing" stlye="float:left" disabled>Difficulty of breathing </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_painful_urination" stlye="float:left" disabled>Painful urination </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_elevated_bp" stlye="float:left" disabled>Elevated blood pressure ≥ 120/90 </td>
                                                                    
                                                                </tr>
                                                        </table>
                                                    </div> -->
                                    </div>
                                 
                            </div>

                            <div id="menu3" class="tab-pane fade">
                                <button class="btn btn-info btn-flat new_btn_add_lab"><i class="fa fa-plus"></i> Add Row</button>
                                <button class="btn btn-danger btn-flat new_btn_delete_lab"><i class="fa fa-minus"></i> Delete</button>
                                    <table class="table table-striped pre_pregnancy_table" id="new_table_lab_res">
                                        <tr class="bg-gray">
                                            <th>Date of Lab.</th>
                                            <th>CBC Result</th>
                                            <th>UA Result</th>
                                            <th>UTZ</th>
                                            <th>Blood Type</th>
                                            <th>HBsAg Result</th>
                                            <th>VDRL Result</th>
                                            <th>Management/Intervention</th>
                                        </tr>
                                        <tr>
                                            <td> <input type="text" class="form-control date_of_lab" placeholder="mm/dd/yyyy" name="date_of_lab[]"></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Hgb: <input type="text" class="form-control" name="cbc_hgb[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        WBC: <input type="text" class="form-control" name="cbc_wbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="cbc_rbc[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Platelet: <input type="text" class="form-control" name="cbc_platelet[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Hct: <input type="text" class="form-control" name="cbc_hct[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Pus: <input type="text" class="form-control" name="ua_pus[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="ua_rbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    <br>
                                                        Sugar: <input type="text" class="form-control" name="ua_sugar[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Specific Gravity: <input type="text" class="form-control" name="ua_gravity[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Albumin: <input type="text" class="form-control" name="ua_albumin[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <textarea name="utz[]" class="form-control"></textarea> </td>
                                            <td rowspan="5" id="blood_type">
                                                    <select name="blood_type" class="form-control-select select2 new_blood_type" required>
                                                        <option value="">Select type...</option>
                                                        <option value="a+">A+</option>
                                                        <option value="a-">A-</option>
                                                        <option value="b+">B+</option>
                                                        <option value="b-">B-</option>
                                                        <option value="ab+">AB+</option>
                                                        <option value="ab-">AB-</option>
                                                        <option value="o+">O+</option>
                                                        <option value="o-">O-</option>
                                                    </select> 
                                            </td>
                                            <td rowspan="5" id="hbsag_result">
                                                    <select name="hbsag_result" class="form-control-select select2 new_hbsag_result" required>
                                                        <option value="">Select HBsAg...</option>
                                                        <option value="reactive">Reactive</option>
                                                        <option value="non_reactive">Non-Reactine</option>
                                                    </select> 
                                            </td>
                                            <td rowspan="5" id="vdrl_result"> 
                                                    <select name="vdrl_result" class="form-control-select select2 new_vdrl_result" required>
                                                        <option value="">Select VDRL...</option>
                                                        <option value="reactive">Reactive</option>
                                                        <option value="non_reactive">Non-Reactine</option>
                                                    </select> 
                                            </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <!-- <tr>
                                           <td> <input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Hgb: <input type="text" class="form-control" name="cbc_hgb[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        WBC: <input type="text" class="form-control" name="cbc_wbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="cbc_rbc[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Platelet: <input type="text" class="form-control" name="cbc_platelet[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Hct: <input type="text" class="form-control" name="cbc_hct[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Pus: <input type="text" class="form-control" name="ua_pus[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="ua_rbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Sugar: <input type="text" class="form-control" name="ua_sugar[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Specific Gravity: <input type="text" class="form-control" name="ua_gravity[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Albumin: <input type="text" class="form-control" name="ua_albumin[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <textarea name="utz[]" class="form-control"></textarea> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td><input type="text" class="form-control" name="cbc_result[]"> </td>
                                            <td><input type="text" class="form-control" name="ua_result[]"> </td>
                                            <td><input type="text" class="form-control" name="utz[]"> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td><input type="text" class="form-control" name="cbc_result[]"> </td>
                                            <td><input type="text" class="form-control" name="ua_result[]"> </td>
                                            <td><input type="text" class="form-control" name="utz[]"> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td><input type="text" class="form-control" name="cbc_result[]"> </td>
                                            <td><input type="text" class="form-control" name="ua_result[]"> </td>
                                            <td><input type="text" class="form-control" name="utz[]"> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr> -->
                                    </table>
                            </div>

                            <!-- <div id="menu4" class="tab-pane fade">
                                    <table class="table table-striped pre_pregnancy_table">
                                        <tr class="bg-gray">
                                            <th>Monitoring</th>
                                            <th>15 min.</th>
                                            <th>30 min.</th>
                                            <th>45 min.</th>
                                            <th>60 min.</th>
                                            <th>Remarks</th>
                                        </tr>
                                        <tr>
                                            <td>BP</td>
                                            <td> <input type="text" class="form-control" name="bp_15"> </td>
                                            <td> <input type="text" class="form-control" name="bp_30"> </td>
                                            <td> <input type="text" class="form-control" name="bp_45"> </td>
                                            <td> <input type="text" class="form-control" name="bp_60"> </td>
                                            <td> <textarea name="bp_remarks" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td>TEMP</td>
                                            <td> <input type="text" class="form-control" name="temp_15"> </td>
                                            <td> <input type="text" class="form-control" name="temp_30"> </td>
                                            <td> <input type="text" class="form-control" name="temp_45"> </td>
                                            <td> <input type="text" class="form-control" name="temp_60"> </td>
                                            <td> <textarea name="temp_remaks" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td>HR</td>
                                            <td> <input type="text" class="form-control" name="hr_15"> </td>
                                            <td> <input type="text" class="form-control" name="hr_30"> </td>
                                            <td> <input type="text" class="form-control" name="hr_45"> </td>
                                            <td> <input type="text" class="form-control" name="hr_60"> </td>
                                            <td> <textarea name="hr_remarks" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td>RR</td>
                                            <td> <input type="text" class="form-control" name="rr_15"> </td>
                                            <td> <input type="text" class="form-control" name="rr_30"> </td>
                                            <td> <input type="text" class="form-control" name="rr_45"> </td>
                                            <td> <input type="text" class="form-control" name="rr_60"> </td>
                                            <td> <textarea name="rr_remarks" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td>O2Sat</td>
                                            <td> <input type="text" class="form-control" name="o2sat_15"> </td>
                                            <td> <input type="text" class="form-control" name="o2sat_30"> </td>
                                            <td> <input type="text" class="form-control" name="o2sat_45"> </td>
                                            <td> <input type="text" class="form-control" name="o2sat_60"> </td>
                                            <td> <textarea name="o2sat_remaks" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td>FHT</td>
                                            <td> <input type="text" class="form-control" name="fht_15"> </td>
                                            <td> <input type="text" class="form-control" name="fht_30"> </td>
                                            <td> <input type="text" class="form-control" name="fht_45"> </td>
                                            <td> <input type="text" class="form-control" name="fht_60"> </td>
                                            <td> <textarea name="fht_remarks" class="form-control"></textarea> </td>
                                        </tr>
                                    </table>
                            </div> -->

                            <!-- <div id="menu5" class="tab-pane fade">
                                    <table class="table table-striped">

                                        <tr>
                                            <td width="25%">
                                                 <label>Delivery Outcome:  </label> 
                                                    <select name="delivery_outcome" class="form-control-select select2" required>
                                                        <option value="">Select Outcome...</option>
                                                        <option value="fullterm">Fullterm</option>
                                                        <option value="preterm">Preterm</option>
                                                        <option value="stillbirth">Stillbirth</option>
                                                        <option value="abortion">Abortion</option>
                                                    </select> 
                                            </td>
                                            <td width="25%"> <label> Birth Attendant:   </label> 
                                                    <select name="birth_attendant" class="form-control-select select2" required>
                                                        <option value="">Select Attendant...</option>
                                                        <option value="md">MD</option>
                                                        <option value="rn">RN</option>
                                                        <option value="rm">RM</option>
                                                    </select>
                                            </td>

                                            <td width="25%">  <label> Status on Discharge:   </label> 
                                                    <select name="status_on_discharge" class="form-control-select select2" required>
                                                        <option value="">Select Status...</option>
                                                        <option value="expired">Expired</option>
                                                        <option value="improved">Improved</option>
                                                        <option value="hama">HAMA</option>
                                                    </select>
                                            </td>
                                            <td width="25%">  <label> Type of Delivery:   </label> 
                                                    <select name="type_of_delivery" class="form-control-select select2" required>
                                                        <option value="">Select Delivery...</option>
                                                        <option value="nsvd">Normal Spontaneous Vaginal Delivery (NSVD)</option>
                                                        <option value="caesarean">Caesarean</option>
                                                        <option value="vaginal_after_caesarean">Vaginal Birth After Caesarean</option>
                                                        <option value="assisted_vaginal_delivery">Assisted Vaginal Delivery</option>
                                                    </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">  
                                            <?php
                                                $data = App\Diagnosis::where('void',0)
                                                ->orderby('id','asc')
                                                ->get();
                                            ?>      
                                                <label> Final Diagnosis with ICD 10 code:   </label>   
                                                 
                                                
                                                    <select name="final_diagnosis[]" id="choices-multiple-remove-button" class="form-control" style="width: 10%" required multiple>
                                                        @foreach($data as $dataa)
                                                            <option defaultValue="{{ $dataa->id }}">{{ $dataa->diagcode }} {{ $dataa->diagdesc}}</option>
                                                        @endforeach
                                                    </select>
                                            </td>
                                        </tr>
        
                                    </table>
                            </div> -->

                        </div>
                        
                    </div>

                    <div class="row">

                    </div>


                <div class="form-fotter pull-right">
                    <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Back</button>
                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-send"></i> Send</button>
                </div>
                <div class="clearfix"></div>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" role="dialog" id="pregnantAddData">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="POST" class="form-submit" action="{{ url('doctor/pregnant/add/info') }}" id="pregnant_add_form">
            <div class="jim-content">
                @include('include.header_form')
                <div class="title-form">Risk Assessment Check list for Pregnant Women</div>
                {{ csrf_field() }}
                    <input type="hidden" name="patient_id" class="patient_id" value="" />
                    <input type="hidden" name="date_referred" class="date_referred" value="{{ date('Y-m-d H:i:s') }}" />
                    <input type="hidden" name="code" value="" />
                    <input type="hidden" name="source" value="{{ $source }}" />
                    <input type="hidden" name="referring_name" value="{{ $myfacility->name }}" />
                    <input type="hidden" name="referring_facility" value="{{ $myfacility->id }}" />
                    <div class="row">

                        <h2>Patients Information</h2>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#personnal">Personnal Data</a></li>
                            <li><a data-toggle="tab" href="#antepartum">Antepartum Conditions</a></li>
                            <li><a data-toggle="tab" href="#sign">Sign and Symptoms</a></li>
                            <li><a data-toggle="tab" href="#lab">Lab Result</a></li>
                            <!-- <li><a data-toggle="tab" href="#menu4">Vital Signs</a></li> -->
                            <!-- <li><a data-toggle="tab" href="#menu5">Pregnancy Outcome</a></li> -->
                        </ul>

                        <div class="tab-content">

                            <div id="personnal" class="tab-pane fade in active">
                                    <table class="table table-striped">
                                        <tr class="bg-gray">
                                            <th colspan="5">A.I Personnal Data</th>
                                        </tr>
                                        <tr>
                                            <td width="25%">Referring Facility: <span class="text-primary">{{ $myfacility->name }} </td>
                                            <td width="25%">Address of facility: <span class="text-primary">{{ $myfacility->address }}</span> </td>
                                            <td width="25%" >PHIC: <span class="text-primary phic_id"></span> </td>
                                            <td width="25%" colspan="4">Referred Date: <span class="text-primary">{{ date('l M d, Y') }}</span> </td>
                           
                                        </tr>
                                        <tr>
                                            <td >Name of Patient: <span class="text-primary patient_name"></span> </td>
                                            <td>Age: <span class="text-primary patient_age"></span> </td>
                                            <td>Sex: <span class="text-primary preg_patient_sex"></span> </td>
                                            <td>
                                                Educational Attainment:
                                                    <select name="educ_attainment" class="form-control educ_attainment" required>
                                                        <option value="">Select Attainment...</option>
                                                        <option value="elementary">Elementary</option>
                                                        <option value="highschool">Highschool</option>
                                                        <option value="college">College</option>
                                                    </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address of Patient: <span class="text-primary patient_address"></span> </td>
                                            <td>Birthday: <span class="text-primary patient_dob"></span></td>
                                            <td>Marital Status: <span class="text-primary preg_civil_status"></span> </td>
                                            <td>
                                                Family Monthly Income:
                                                    <select name="family_income" class="form-control family_income" required>
                                                        <option value="">Select Income...</option>
                                                        <option value="rich"> 219,140</option>
                                                        <option value="high">131,484 - 219,140</option>
                                                        <option value="upper_middle">76,670 - 131,483</option>
                                                        <option value="middle">43,829 - 76,669</option>
                                                        <option value="lower_middle">21,915 - 43,828</option>
                                                        <option value="low">10,958 - 21,914</option>
                                                        <option value="poor"><10,957</option>
                                                    </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Contact No. of Patient: <span class="text-primary patient_contact"></span> </td>
                                            <td>Religion: <input type="text" class="form-control religion" name="religion" style="width: 100%;"> </td>
                                            <td>Ethnicity: <input type="text" class="form-control ethnicity" name="ethnicity" style="width: 100%;"> </td>
                                            <td>Sibling Rank: 
                                                <input type="text" class="form-control sibling_rank" name="sibling_rank" style="width: 100%;"> Out of  
                                                <input type="text" class="form-control out_of" name="out_of" style="width: 100%;"> 
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="table table-striped">
                                        <tr class="bg-gray">
                                            <th colspan="6">A.II Personnal Data</th>
                                        </tr>
                                        <tr>
                                            <td>Gravidity: <input type="text" class="form-control" name="gravidity" style="width: 100%;"> </td>
                                            <td>Parity: <input type="text" class="form-control" name="parity" style="width: 100%;"> </td>
                                            <td>Height (m): <input type="text" class="form-control" name="height" id="add_refer_height" style="width: 100%;"> </td>
                                            <td>Weigth (kg): <input type="text" class="form-control" name="weigth" id="add_refer_weigth" style="width: 100%;"></td>
                                            <td>Fundic Height: <input type="text" class="form-control fh_personnal" name="fundic_height" style="width: 100%;"> </td>
                                            <td>HR: <input type="text" class="form-control hr_personnal" name="hr" style="width: 100%;"></td>
                                        </tr>
                                        <tr>
                                            <td>LMP: <input type="text" class="form-control add_lmp_date" name="lmp" placeholder="mm/dd/yyyy" style="width: 100%;">  </td>
                                            <td>EDC/EDD: <input type="text" id="edc_edd" class="form-control edc_edd" name="edc_edd" placeholder="mm/dd/yyyy" style="width: 100%;" readonly> </td>
                                            <td>FTPAL: <input type="text" class="form-control" name="ftpal" style="width: 100%;"> </td>
                                            <td>BMI: <input type="text"class="form-control" id="add_new_bmi" name="bmi" style="width: 100%;"> </td>
                                            <td>BP: <input type="text" class="form-control bp_personnal" name="bp" style="width: 100%;"></td>
                                            <td>TEMP: <input type="text" class="form-control temp_personnal" name="temp" style="width: 100%;"></td>
                                        </tr>
                                        <tr>
                                            <td>RR: <input type="text" class="form-control rr_personnal" name="rr" style="width: 100%;"></td>
                                            <td>Td1: <input type="text" placeholder="mm/dd/yyyy" class="form-control td1" name="td1" style="width: 100%;"></td>
                                            <td>Td2: <input type="text" placeholder="mm/dd/yyyy" class="form-control td2" name="td2" style="width: 100%;"> </td>
                                            <td>Td3: <input type="text" placeholder="mm/dd/yyyy" class="form-control td3" name="td3" style="width: 100%;"> </td>
                                            <td>Td4: <input type="text" placeholder="mm/dd/yyyy" class="form-control td4" name="td4" style="width: 100%;"> </td>
                                            <td>Td5: <input type="text" placeholder="mm/dd/yyyy" class="form-control td5" name="td5" style="width: 100%;"> </td>
                                        </tr>
                                    </table>
                            </div>

                            <div id="antepartum" class="tab-pane fade">
                                   <table class="table table-striped pre_pregnancy_table">
                                        <tr class="bg-gray">
                                            <th>Risk Factor</th>
                                            <th>Risk Factor</th>
                                            <th>Risk Factor</th>
                                            <th>Risk Factor</th>
                                            <th>Risk Factor</th>
                                            <th>Remarks/Management</th>
                                        </tr>
                                        <tr>
                                            <td> Hypertension <br> <input type="checkbox" value="yes" class="hypertension" name="hypertension"></td>
                                            <td> Anemia <br> <input type="checkbox" value="yes" class="anemia" name="anemia"></td>
                                            <td> Malaria <br> <input type="checkbox" value="yes" class="malaria" name="malaria"></td>
                                            <td> Cancer <br> <input type="checkbox" value="yes" class="cancer" name="cancer"></td>
                                            <td> Allergies <br> <input type="checkbox" value="yes" class="allergies" name="allergies"></td>
                                            <td rowspan="5"> 

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <small class="text-info">Subjective</small><br>
                                                       <textarea class="form-control" name="ante_subjective" style="resize: none;width: 100%;"> </textarea>
                                                    </div>
                                                </div>    

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small class="text-info">BP</small><br>
                                                        <input type="text" class="form-control bp_antepartum"  name="ante_bp" style="width: 100%;">
                                                        <small class="text-info">HR</small><br>
                                                        <input type="text" class="form-control hr_antepartum"  name="ante_hr" style="width: 100%;">
                                                        <small class="text-info">FH</small><br>
                                                        <input type="text" class="form-control fh_antepartum"  name="ante_fh" style="width: 100%;">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <small class="text-info">TEMP</small><br>
                                                         <input type="text" class="form-control temp_antepartum"  name="ante_temp" style="width: 100%;">
                                                        <small class="text-info">RR</small><br>
                                                         <input type="text" class="form-control rr_antepartum"  name="ante_rr" style="width: 100%;">
                                                        <small class="text-info">FHT</small><br>
                                                         <input type="text" class="form-control"  name="ante_fht" style="width: 100%;">
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <small class="text-info">Other Physical Examination</small><br>
                                                       <textarea class="form-control" name="ante_other_physical_exam" style="resize: none;width: 100%;"> </textarea>
                                                    </div>
                                                </div> 

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <small class="text-info">Assessment/Diagnosis</small><br>
                                                       <textarea class="form-control" name="ante_assessment_diagnosis" style="resize: none;width: 100%;"> </textarea>
                                                    </div>
                                                </div> 

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <small class="text-info">Plan/Intervention</small><br>
                                                       <textarea class="form-control" name="ante_plan_intervention" style="resize: none;width: 100%;"> </textarea>
                                                    </div>
                                                </div> 

                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Renal Disease<br> <input type="checkbox" value="yes" class="renal_disease" name="renal_disease"></</td>
                                            <td> Typhoid Disorders <br> <input type="checkbox" value="yes" class="typhoid_disorders" name="typhoid_disorders"></td>
                                            <td> Hypo/Hyperthyroidism <br> <input type="checkbox" value="yes" class="hypo_hyperthyroidism" name="hypo_hyper"></td>
                                            <td> Tuberculosis <br> <input type="checkbox" value="yes" class="tuberculosis" name="tuberculosis"></td>
                                            <td> Diabetes Mellitus <br> <input type="checkbox" value="yes" class="diabetes_mellitus" name="diabetes_mellitus"></td>
                                        </tr>
                                        <tr>
                                            <td> Hepatitis B Infection<br> <input type="checkbox" value="yes" class="hepatitisb_infection" name="hepatatis_b"></</td>
                                            <td> HIV-AIDs/STI <br> <input type="checkbox" value="yes" class="hiv_sti" name="hiv_sti"></td>
                                            <td> Seizure Disorder <br> <input type="checkbox" value="yes" class="seizure_disorder" name="seizure_disorder"></td>
                                            <td> Cardiovascular disease <br> <input type="checkbox" value="yes" class="cadiovascular_disease" name="cardiovascular_disease"></td>
                                            <td> Malnutrition (<18.5 BMI) <br> <input type="checkbox" value="yes" class="malnutrition" name="malnutrition"></td>
                                        </tr>
                                        <tr>
                                            <td> Hemotilgic/Bleeding disorder<br> <input type="checkbox" value="yes" class="hemotilgic_bleeding" name="hemotilgic_disorder"></td>
                                            <td> Alcohol/Substance Abuse <br> <input type="checkbox" value="yes" class="alcohol_abuse" name="substance_abuse"></td>
                                            <td> Patient w/ anti-phospholipid syndrome <br> <input type="checkbox" value="yes" class="phospholipid_syndrome" name="anti_phospholipid"></td>
                                            <td> Obstructive or restrictive pulmonary disease (Asthma) <br> <input type="checkbox" value="yes" class="asthma" name="restrictive_pulmonary"></td>
                                            <td> Patients w/psychiatirc conditions and/mental retardation <br> <input type="checkbox" value="yes" class="psychiatric_mental" name="mental_retardation"></td>
                                        </tr>
                                        <tr>
                                            <td> Habitual abortion (2 consecutive abortion and 3/more repeated abortion)<br> <input type="checkbox" value="yes" class="habitual_abortion" name="habitual_abortion"></td>
                                            <td> Birth of fetus with congenital anomaly <br> <input type="checkbox" value="yes" class="fetus_congenital" name="fetus_congenital"></td>
                                            <td> Previous caesarean section <br> <input type="checkbox" value="yes" class="caesarean_section" name="previous_caesarean"></td>
                                            <td> Preterm Delivery resulting to stillbirth or neonatal death <br> <input type="checkbox" value="yes" class="neonatal_death" name="preterm_delivery"></td>
                                            <td>
                                                <small class="text-info">Others</small><br>
                                                <textarea class="form-control" name="others" class="others" style="resize: none;width: 100%;"> </textarea> 
                                            </td>
                                        </tr>
                                    </table>
                            </div>

                            <div id="sign" class="tab-pane fade">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#previous">New Data</a></li>
                                        <!-- <li><a data-toggle="tab" href="#current">Previous Data</a></li> -->
                                    </ul>

                                    <div class="tab-content">
                                                    <div id="previous" class="tab-pane fade in active">
                                                        <table class="table table-striped sign_symthoms_table">
                                                                <tr class="bg-gray">
                                                                    <th rowspan="4" width="50%"> 
                                                                        <br><br><br><br><br><h3>Risk Factor</h3>
                                                                            (a CHECK to ATLEAST ONE of the boxex indicates REFERRAL to a higher facility) 
                                                                    </th>
                                                                    <th> 
                                                                        <span> 
                                                                            <select style="width:50px;" class="new_trimester" name="no_trimester" required readonly>
                                                                            <option style="width:150px;" value="">...</option>
                                                                            <option value="1st">1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            </select> Trimester 
                                                                        </span>
                                                                    </th>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> 
                                                                        <span> 
                                                                            <select style="width:50px;" name="no_visit" class="new_visit_no" required>
                                                                            <option style="width:150px;" value="" selected>...</option>
                                                                            <option value="1st" >1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            <option value="4th">4th</option>
                                                                            <option value="5th">5th</option>
                                                                            </select> Visit 
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> 
                                                                        <center>
                                                                            <span> Date: <input  class="form-control add_date_of_visit" placeholder="mm/dd/yyyy" type="text" name="date_of_visit">  <br>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> <b>Remarks</b></td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="vaginal_spotting" name="vaginal_spotting" value="yes" stlye="float:left">Vaginal spotting or bleeding</td>
                                                                    <td rowspan="13">
                                                                        <center>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Subjective</small><br>
                                                                                    <textarea class="form-control" name="sign_subjective" style="resize: none;width: 100%;"> </textarea>
                                                                                </div>
                                                                            </div>    

                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <small class="text-info">AOG</small><br>
                                                                                    <input type="text" class="form-control new_aog"  name="sign_aog" style="width: 100%;" readonly>
                                                                                </div>

                                                                                <div class="col-md-4">

                                                                                </div>
                                                                            </div>    

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">BP</small><br>
                                                                                    <input type="text" class="form-control bp_signsymptoms"  name="sign_bp" style="width: 100%;">
                                                                                    <small class="text-info">HR</small><br>
                                                                                    <input type="text" class="form-control hr_signsymptoms"  name="sign_hr" style="width: 100%;">
                                                                                    <small class="text-info">FH</small><br>
                                                                                    <input type="text" class="form-control fh_signsymptoms"  name="sign_fh" style="width: 100%;">
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">TEMP</small><br>
                                                                                    <input type="text" class="form-control temp_signsymptoms"  name="sign_temp" style="width: 100%;">
                                                                                    <small class="text-info">RR</small><br>
                                                                                    <input type="text" class="form-control rr_signsymptoms"  name="sign_rr" style="width: 100%;">
                                                                                    <small class="text-info">FHT</small><br>
                                                                                    <input type="text" class="form-control fht_signsymptoms"  name="sign_fht" style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Other Physical Examination</small><br>
                                                                                <textarea class="form-control sign_other_physical_exam" id="sign_other_physical_exam" name="sign_other_physical_exam" style="resize: none;width: 100%;"></textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Assessment/Diagnosis</small><br>
                                                                                <textarea class="form-control sign_assessment_diagnosis" id="sign_assessment_diagnosis" name="sign_assessment_diagnosis" style="resize: none;width: 100%;"></textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Plan/Intervention</small><br>
                                                                                <textarea class="form-control" name="sign_plan_intervention" style="resize: none;width: 100%;"></textarea>
                                                                                </div>
                                                                            </div> 
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td><input type="checkbox" class="severe_nausea" value="yes" name="severe_nausea" stlye="float:left">Severe nausea and vomiting </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="significant_decline" value="yes" name="significant_decline" stlye="float:left">Significant decline fetal movement (less than 10 in 12 hrs during 2 ½ of pregnancy) </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="persistent_contractions" value="yes" name="persistent_contractions" stlye="float:left">Persistent contractions</td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="premature_rupture" value="yes" name="premature_rupture" stlye="float:left">Premature rupture of the bag of membrane </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="fetal_pregnancy" value="yes" name="fetal_pregnancy" stlye="float:left">Multi fetal pregnancy </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="severe_headache" value="yes" name="severe_headache" stlye="float:left">Persistent severe headache, dizziness, or blurring of vision </td>
                                                                    
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="abdominal_pain" value="yes" name="abdominal_pain" stlye="float:left">Abdominal pain or epigastric pain </td>
                                                                
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="edema_hands" value="yes" name="edema_hands" stlye="float:left">Edema of the hands, feet or face </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box"> 
                                                                    <td ><input type="checkbox" class="fever_pallor" value="yes" name="fever_pallor" stlye="float:left">Fever or pallor </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="seizure_consciousness" value="yes" name="seizure_consciousness" stlye="float:left">Seizure or loss of consciousness </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="difficulty_breathing" value="yes" name="difficulty_breathing" stlye="float:left">Difficulty of breathing </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="painful_urination" value="yes" name="painful_urination" stlye="float:left">Painful urination </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="elevated_bp" value="yes" name="elevated_bp" stlye="float:left">Elevated blood pressure ≥ 120/90 </td>
                                                                    
                                                                </tr>
                                                        </table>
                                                    </div>

                                                    <div id="current" class="tab-pane fade">
                                                        <table class="table table-striped sign_symthoms_table">
                                                                <tr class="bg-gray">
                                                                    <th rowspan="4" width="50%"> 
                                                                        <br><br><br><br><br><h3>Risk Factor</h3>
                                                                            (a CHECK to ATLEAST ONE of the boxex indicates REFERRAL to a higher facility) 
                                                                    </th>
                                                                    <th> 
                                                                        <span> 
                                                                            <select style="width:50px;" class="prev_trimester" disabled>
                                                                            <option styple="width:150px;" value="">...</option>
                                                                            <option value="1st">1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            </select> Trimester 
                                                                        </span>
                                                                    </th>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> 
                                                                        <span> 
                                                                            <select style="width:50px;" class="prev_visit" disabled>
                                                                            <option styple="width:150px;" value="">...</option>
                                                                            <option value="1st">1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            <option value="4th">4th</option>
                                                                            <option value="5th">5th</option>
                                                                            <option value="6th">6th</option>
                                                                            <option value="7th">7th</option>
                                                                            <option value="8th">8th</option>
                                                                            <option value="9th">9th</option>
                                                                            <option value="10th">10th</option>
                                                                            <option value="11th">11th</option>
                                                                            <option value="12th">12th</option>
                                                                            </select> Visit 
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> 
                                                                        <center>
                                                                            <span> Date: <input  class="form-control prev_date"  type="date" disabled>  <br>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> <b>Remarks</b></td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_viganal_bleeding" stlye="float:left" disabled>Vaginal spotting or bleeding</td>
                                                                    <td rowspan="13">
                                                                        <center>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Subjective</small><br>
                                                                                    <textarea class="form-control prev_subjective" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div>    


                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <small class="text-info">AOG</small><br>
                                                                                    <input type="text" class="form-control prev_aog" style="width: 100%;" disabled>
                                                                                </div>

                                                                                <div class="col-md-4">

                                                                                </div>
                                                                            </div>  

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">BP</small><br>
                                                                                    <input type="text" class="form-control prev_bp"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">HR</small><br>
                                                                                    <input type="text" class="form-control prev_hr"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">FH</small><br>
                                                                                    <input type="text" class="form-control prev_fh"  style="width: 100%;" disabled>
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">TEMP</small><br>
                                                                                    <input type="text" class="form-control prev_temp"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">RR</small><br>
                                                                                    <input type="text" class="form-control prev_rr"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">FHT</small><br>
                                                                                    <input type="text" class="form-control prev_fht"  style="width: 100%;" disabled>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Other Physical Examination</small><br>
                                                                                <textarea class="form-control prev_other_exam" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Assessment/Diagnosis</small><br>
                                                                                <textarea class="form-control prev_assestment_diagnosis" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Plan/Intervention</small><br>
                                                                                <textarea class="form-control prev_plan_intervention" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div> 
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_severe_nausea" stlye="float:left" disabled>Severe nausea and vomiting </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_significant_decline" stlye="float:left" disabled>Significant decline fetal movement (less than 10 in 12 hrs during 2 ½ of pregnancy) </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_persistent_contractions" stlye="float:left" disabled>Persistent contractions</td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_premature_rupture" stlye="float:left" disabled>Premature rupture of the bag of membrane </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_multi_pregnancy" stlye="float:left" disabled>Multi fetal pregnancy </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox"  class="prev_persistent_severe" stlye="float:left" disabled>Persistent severe headache, dizziness, or blurring of vision </td>
                                                                    
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_abdominal_pain" stlye="float:left" disabled>Abdominal pain or epigastric pain </td>
                                                                
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_edema_hands" stlye="float:left" disabled>Edema of the hands, feet or face </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box"> 
                                                                    <td ><input type="checkbox" class="prev_fever_pallor" stlye="float:left" disabled>Fever or pallor </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_seiszure_consciousness" stlye="float:left" disabled>Seizure or loss of consciousness </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_difficulty_breathing" stlye="float:left" disabled>Difficulty of breathing </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_painful_urination" stlye="float:left" disabled>Painful urination </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_elevated_bp" stlye="float:left" disabled>Elevated blood pressure ≥ 120/90 </td>
                                                                    
                                                                </tr>
                                                        </table>
                                                    </div>
                                    </div>
                                 
                            </div>

                            <div id="lab" class="tab-pane fade">
                                <button class="btn btn-info btn-flat add_btn_add_lab"><i class="fa fa-plus"></i> Add Row</button>
                                <button class="btn btn-danger btn-flat add_btn_delete_lab"><i class="fa fa-minus"></i> Delete</button>
                                    <table class="table table-striped pre_pregnancy_table" id="add_table_lab_res">
                                        <tr class="bg-gray">
                                            <th>Date of Lab.</th>
                                            <th>CBC Result</th>
                                            <th>UA Result</th>
                                            <th>UTZ</th>
                                            <th>Blood Type</th>
                                            <th>HBsAg Result</th>
                                            <th>VDRL Result</th>
                                            <th>Management/Intervention</th>
                                        </tr>
                                        <tr>
                                            <td> 
                                                <input type="text" class="form-control date_of_lab" placeholder="mm/dd/yyyy" name="date_of_lab[]">
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Hgb: <input type="text" class="form-control" name="cbc_hgb[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        WBC: <input type="text" class="form-control" name="cbc_wbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="cbc_rbc[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Platelet: <input type="text" class="form-control" name="cbc_platelet[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Hct: <input type="text" class="form-control" name="cbc_hct[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Pus: <input type="text" class="form-control" name="ua_pus[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="ua_rbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    <br>
                                                        Sugar: <input type="text" class="form-control" name="ua_sugar[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Specific Gravity: <input type="text" class="form-control" name="ua_gravity[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Albumin: <input type="text" class="form-control" name="ua_albumin[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <textarea name="utz[]" class="form-control"></textarea> </td>
                                            <td rowspan="5" id="blood_type">
                                                    <select name="blood_type" class="form-control-select select2" required>
                                                        <option value="">Select type...</option>
                                                        <option value="a+">A+</option>
                                                        <option value="a-">A-</option>
                                                        <option value="b+">B+</option>
                                                        <option value="b-">B-</option>
                                                        <option value="ab+">AB+</option>
                                                        <option value="ab-">AB-</option>
                                                        <option value="o+">O+</option>
                                                        <option value="o-">O-</option>
                                                    </select> 
                                            </td>
                                            <td rowspan="5" id="hbsag_result">
                                                    <select name="hbsag_result" class="form-control-select select2" required>
                                                        <option value="">Select HBsAg...</option>
                                                        <option value="reactive">Reactive</option>
                                                        <option value="non_reactive">Non-Reactine</option>
                                                    </select> 
                                            </td>
                                            <td rowspan="5" id="vdrl_result"> 
                                                    <select name="vdrl_result" class="form-control-select select2" required>
                                                        <option value="">Select VDRL...</option>
                                                        <option value="reactive">Reactive</option>
                                                        <option value="non_reactive">Non-Reactine</option>
                                                    </select> 
                                            </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <!-- <tr>
                                           <td> <input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Hgb: <input type="text" class="form-control" name="cbc_hgb[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        WBC: <input type="text" class="form-control" name="cbc_wbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="cbc_rbc[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Platelet: <input type="text" class="form-control" name="cbc_platelet[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Hct: <input type="text" class="form-control" name="cbc_hct[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Pus: <input type="text" class="form-control" name="ua_pus[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="ua_rbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Sugar: <input type="text" class="form-control" name="ua_sugar[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Specific Gravity: <input type="text" class="form-control" name="ua_gravity[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Albumin: <input type="text" class="form-control" name="ua_albumin[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <textarea name="utz[]" class="form-control"></textarea> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td><input type="text" class="form-control" name="cbc_result[]"> </td>
                                            <td><input type="text" class="form-control" name="ua_result[]"> </td>
                                            <td><input type="text" class="form-control" name="utz[]"> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td><input type="text" class="form-control" name="cbc_result[]"> </td>
                                            <td><input type="text" class="form-control" name="ua_result[]"> </td>
                                            <td><input type="text" class="form-control" name="utz[]"> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td><input type="text" class="form-control" name="cbc_result[]"> </td>
                                            <td><input type="text" class="form-control" name="ua_result[]"> </td>
                                            <td><input type="text" class="form-control" name="utz[]"> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr> -->
                                    </table>
                            </div>

                            <!-- <div id="menu4" class="tab-pane fade">
                                    <table class="table table-striped pre_pregnancy_table">
                                        <tr class="bg-gray">
                                            <th>Monitoring</th>
                                            <th>15 min.</th>
                                            <th>30 min.</th>
                                            <th>45 min.</th>
                                            <th>60 min.</th>
                                            <th>Remarks</th>
                                        </tr>
                                        <tr>
                                            <td>BP</td>
                                            <td> <input type="text" class="form-control" name="bp_15"> </td>
                                            <td> <input type="text" class="form-control" name="bp_30"> </td>
                                            <td> <input type="text" class="form-control" name="bp_45"> </td>
                                            <td> <input type="text" class="form-control" name="bp_60"> </td>
                                            <td> <textarea name="bp_remarks" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td>TEMP</td>
                                            <td> <input type="text" class="form-control" name="temp_15"> </td>
                                            <td> <input type="text" class="form-control" name="temp_30"> </td>
                                            <td> <input type="text" class="form-control" name="temp_45"> </td>
                                            <td> <input type="text" class="form-control" name="temp_60"> </td>
                                            <td> <textarea name="temp_remaks" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td>HR</td>
                                            <td> <input type="text" class="form-control" name="hr_15"> </td>
                                            <td> <input type="text" class="form-control" name="hr_30"> </td>
                                            <td> <input type="text" class="form-control" name="hr_45"> </td>
                                            <td> <input type="text" class="form-control" name="hr_60"> </td>
                                            <td> <textarea name="hr_remarks" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td>RR</td>
                                            <td> <input type="text" class="form-control" name="rr_15"> </td>
                                            <td> <input type="text" class="form-control" name="rr_30"> </td>
                                            <td> <input type="text" class="form-control" name="rr_45"> </td>
                                            <td> <input type="text" class="form-control" name="rr_60"> </td>
                                            <td> <textarea name="rr_remarks" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td>O2Sat</td>
                                            <td> <input type="text" class="form-control" name="o2sat_15"> </td>
                                            <td> <input type="text" class="form-control" name="o2sat_30"> </td>
                                            <td> <input type="text" class="form-control" name="o2sat_45"> </td>
                                            <td> <input type="text" class="form-control" name="o2sat_60"> </td>
                                            <td> <textarea name="o2sat_remaks" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td>FHT</td>
                                            <td> <input type="text" class="form-control" name="fht_15"> </td>
                                            <td> <input type="text" class="form-control" name="fht_30"> </td>
                                            <td> <input type="text" class="form-control" name="fht_45"> </td>
                                            <td> <input type="text" class="form-control" name="fht_60"> </td>
                                            <td> <textarea name="fht_remarks" class="form-control"></textarea> </td>
                                        </tr>
                                    </table>
                            </div> -->

                            <!-- <div id="menu5" class="tab-pane fade">
                                    <table class="table table-striped">

                                        <tr>
                                            <td width="25%">
                                                 <label>Delivery Outcome:  </label> 
                                                    <select name="delivery_outcome" class="form-control-select select2" required>
                                                        <option value="">Select Outcome...</option>
                                                        <option value="fullterm">Fullterm</option>
                                                        <option value="preterm">Preterm</option>
                                                        <option value="stillbirth">Stillbirth</option>
                                                        <option value="abortion">Abortion</option>
                                                    </select> 
                                            </td>
                                            <td width="25%"> <label> Birth Attendant:   </label> 
                                                    <select name="birth_attendant" class="form-control-select select2" required>
                                                        <option value="">Select Attendant...</option>
                                                        <option value="md">MD</option>
                                                        <option value="rn">RN</option>
                                                        <option value="rm">RM</option>
                                                    </select>
                                            </td>

                                            <td width="25%">  <label> Status on Discharge:   </label> 
                                                    <select name="status_on_discharge" class="form-control-select select2" required>
                                                        <option value="">Select Status...</option>
                                                        <option value="expired">Expired</option>
                                                        <option value="improved">Improved</option>
                                                        <option value="hama">HAMA</option>
                                                    </select>
                                            </td>
                                            <td width="25%">  <label> Type of Delivery:   </label> 
                                                    <select name="type_of_delivery" class="form-control-select select2" required>
                                                        <option value="">Select Delivery...</option>
                                                        <option value="nsvd">Normal Spontaneous Vaginal Delivery (NSVD)</option>
                                                        <option value="caesarean">Caesarean</option>
                                                        <option value="vaginal_after_caesarean">Vaginal Birth After Caesarean</option>
                                                        <option value="assisted_vaginal_delivery">Assisted Vaginal Delivery</option>
                                                    </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">  
                                            <?php
                                                $data = App\Diagnosis::where('void',0)
                                                ->orderby('id','asc')
                                                ->get();
                                            ?>      
                                                <label> Final Diagnosis with ICD 10 code:   </label>   
                                                 
                                                
                                                    <select name="final_diagnosis[]" id="choices-multiple-remove-button" class="form-control" style="width: 10%" required multiple>
                                                        @foreach($data as $dataa)
                                                            <option defaultValue="{{ $dataa->id }}">{{ $dataa->diagcode }} {{ $dataa->diagdesc}}</option>
                                                        @endforeach
                                                    </select>
                                            </td>
                                        </tr>
        
                                    </table>
                            </div> -->

                        </div>
                        
                    </div>

                    <div class="row">

                    </div>


                <div class="form-fotter pull-right">
                    <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Back</button>
                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-send"></i> Submit</button>
                </div>
                <div class="clearfix"></div>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" role="dialog" id="patientReturnModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="POST" class="form-submit" action="{{ url('doctor/patient/return/pregnant') }}" id="pregnant_form_return">
            <div class="jim-content">
                @include('include.header_form')
                <div class="title-form">Risk Assessment Check list for Pregnant Women</div>
                {{ csrf_field() }}
                <input type="hidden" name="patient_woman_id" class="patient_woman_id"/>
                    <input type="hidden" name="unique_id" class="unique_id"/>
                    <input type="hidden" name="code" class="code"/>
                    <!-- <input type="hidden" name="patient_id" class="patient_id" value="" />
                    <input type="hidden" name="date_referred" class="date_referred" value="{{ date('Y-m-d H:i:s') }}" />
                    <input type="hidden" name="code" value="" />
                    <input type="hidden" name="source" value="{{ $source }}" />
                    <input type="hidden" name="referring_name" value="{{ $myfacility->name }}" />
                    <input type="hidden" name="referring_facility" value="{{ $myfacility->id }}" /> -->
                    <div class="row">
                        <h2>Patients Information</h2>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#sign2">Sign and Symptoms</a></li>
                            <li><a data-toggle="tab" href="#lab2">Lab Result</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="sign2" class="tab-pane fade in active">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#previous">New Data</a></li>
                                        <!-- <li><a data-toggle="tab" href="#current">Previous Data</a></li> -->
                                    </ul>

                                    <div class="tab-content">
                                                    <div id="previous" class="tab-pane fade in active">
                                                        <table class="table table-striped sign_symthoms_table">
                                                                <tr class="bg-gray">
                                                                    <th rowspan="4" width="50%"> 
                                                                        <br><br><br><br><br><h3>Risk Factor</h3>
                                                                            (a CHECK to ATLEAST ONE of the boxex indicates REFERRAL to a higher facility) 
                                                                    </th>
                                                                    <th> 
                                                                        <span> 
                                                                            <select style="width:50px;" class="new_trimester" name="no_trimester" required readonly>
                                                                            <option style="width:150px;" value="">...</option>
                                                                            <option value="1st">1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            </select> Trimester 
                                                                        </span>
                                                                    </th>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> 
                                                                        <span> 
                                                                            <select style="width:50px;" name="no_visit" class="new_visit_no" required>
                                                                            <option style="width:150px;" value="" selected>...</option>
                                                                            <option value="1st" >1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            <option value="4th">4th</option>
                                                                            <option value="5th">5th</option>
                                                                            </select> Visit 
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> 
                                                                        <center>
                                                                         <input  class="form-control lmp_date_return" placeholder="mm/dd/yyyy" type="hidden" name="date_of_visit">
                                                                            <span> Date: <input  class="form-control return_date_of_visit"  type="text" name="date_of_visit">  <br>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> <b>Remarks</b></td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="vaginal_spotting" name="vaginal_spotting" value="yes" stlye="float:left">Vaginal spotting or bleeding</td>
                                                                    <td rowspan="13">
                                                                        <center>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Subjective</small><br>
                                                                                    <textarea class="form-control" name="sign_subjective" style="resize: none;width: 100%;"> </textarea>
                                                                                </div>
                                                                            </div>    

                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <small class="text-info">AOG</small><br>
                                                                                    <input type="text" class="form-control new_aog"  name="sign_aog" style="width: 100%;" readonly>
                                                                                </div>

                                                                                <div class="col-md-4">

                                                                                </div>
                                                                            </div>    

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">BP</small><br>
                                                                                    <input type="text" class="form-control bp_signsymptoms"  name="sign_bp" style="width: 100%;">
                                                                                    <small class="text-info">HR</small><br>
                                                                                    <input type="text" class="form-control hr_signsymptoms"  name="sign_hr" style="width: 100%;">
                                                                                    <small class="text-info">FH</small><br>
                                                                                    <input type="text" class="form-control fh_signsymptoms"  name="sign_fh" style="width: 100%;">
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">TEMP</small><br>
                                                                                    <input type="text" class="form-control temp_signsymptoms"  name="sign_temp" style="width: 100%;">
                                                                                    <small class="text-info">RR</small><br>
                                                                                    <input type="text" class="form-control rr_signsymptoms"  name="sign_rr" style="width: 100%;">
                                                                                    <small class="text-info">FHT</small><br>
                                                                                    <input type="text" class="form-control fht_signsymptoms"  name="sign_fht" style="width: 100%;">
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Other Physical Examination</small><br>
                                                                                <textarea class="form-control sign_other_physical_exam" id="sign_other_physical_exam" name="sign_other_physical_exam" style="resize: none;width: 100%;"></textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Assessment/Diagnosis</small><br>
                                                                                <textarea class="form-control sign_assessment_diagnosis" id="sign_assessment_diagnosis" name="sign_assessment_diagnosis" style="resize: none;width: 100%;"></textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Plan/Intervention</small><br>
                                                                                <textarea class="form-control" name="sign_plan_intervention" style="resize: none;width: 100%;"></textarea>
                                                                                </div>
                                                                            </div> 
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td><input type="checkbox" class="severe_nausea" value="yes" name="severe_nausea" stlye="float:left">Severe nausea and vomiting </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="significant_decline" value="yes" name="significant_decline" stlye="float:left">Significant decline fetal movement (less than 10 in 12 hrs during 2 ½ of pregnancy) </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="persistent_contractions" value="yes" name="persistent_contractions" stlye="float:left">Persistent contractions</td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="premature_rupture" value="yes" name="premature_rupture" stlye="float:left">Premature rupture of the bag of membrane </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="fetal_pregnancy" value="yes" name="fetal_pregnancy" stlye="float:left">Multi fetal pregnancy </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="severe_headache" value="yes" name="severe_headache" stlye="float:left">Persistent severe headache, dizziness, or blurring of vision </td>
                                                                    
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="abdominal_pain" value="yes" name="abdominal_pain" stlye="float:left">Abdominal pain or epigastric pain </td>
                                                                
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="edema_hands" value="yes" name="edema_hands" stlye="float:left">Edema of the hands, feet or face </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box"> 
                                                                    <td ><input type="checkbox" class="fever_pallor" value="yes" name="fever_pallor" stlye="float:left">Fever or pallor </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="seizure_consciousness" value="yes" name="seizure_consciousness" stlye="float:left">Seizure or loss of consciousness </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="difficulty_breathing" value="yes" name="difficulty_breathing" stlye="float:left">Difficulty of breathing </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="painful_urination" value="yes" name="painful_urination" stlye="float:left">Painful urination </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="elevated_bp" value="yes" name="elevated_bp" stlye="float:left">Elevated blood pressure ≥ 120/90 </td>
                                                                    
                                                                </tr>
                                                        </table>
                                                    </div>
<!-- 
                                                    <div id="current" class="tab-pane fade">
                                                        <table class="table table-striped sign_symthoms_table">
                                                                <tr class="bg-gray">
                                                                    <th rowspan="4" width="50%"> 
                                                                        <br><br><br><br><br><h3>Risk Factor</h3>
                                                                            (a CHECK to ATLEAST ONE of the boxex indicates REFERRAL to a higher facility) 
                                                                    </th>
                                                                    <th> 
                                                                        <span> 
                                                                            <select style="width:50px;" class="prev_trimester" disabled>
                                                                            <option styple="width:150px;" value="">...</option>
                                                                            <option value="1st">1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            </select> Trimester 
                                                                        </span>
                                                                    </th>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> 
                                                                        <span> 
                                                                            <select style="width:50px;" class="prev_visit" disabled>
                                                                            <option styple="width:150px;" value="">...</option>
                                                                            <option value="1st">1st</option>
                                                                            <option value="2nd">2nd</option>
                                                                            <option value="3rd">3rd</option>
                                                                            <option value="4th">4th</option>
                                                                            <option value="5th">5th</option>
                                                                            <option value="6th">6th</option>
                                                                            <option value="7th">7th</option>
                                                                            <option value="8th">8th</option>
                                                                            <option value="9th">9th</option>
                                                                            <option value="10th">10th</option>
                                                                            <option value="11th">11th</option>
                                                                            <option value="12th">12th</option>
                                                                            </select> Visit 
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> 
                                                                        <center>
                                                                            <span> Date: <input  class="form-control prev_date"  type="date" disabled>  <br>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-gray">
                                                                    <td> <b>Remarks</b></td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_viganal_bleeding" stlye="float:left" disabled>Vaginal spotting or bleeding</td>
                                                                    <td rowspan="13">
                                                                        <center>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Subjective</small><br>
                                                                                    <textarea class="form-control prev_subjective" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div>    


                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <small class="text-info">AOG</small><br>
                                                                                    <input type="text" class="form-control prev_aog" style="width: 100%;" disabled>
                                                                                </div>

                                                                                <div class="col-md-4">

                                                                                </div>
                                                                            </div>  

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">BP</small><br>
                                                                                    <input type="text" class="form-control prev_bp"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">HR</small><br>
                                                                                    <input type="text" class="form-control prev_hr"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">FH</small><br>
                                                                                    <input type="text" class="form-control prev_fh"  style="width: 100%;" disabled>
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <small class="text-info">TEMP</small><br>
                                                                                    <input type="text" class="form-control prev_temp"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">RR</small><br>
                                                                                    <input type="text" class="form-control prev_rr"  style="width: 100%;" disabled>
                                                                                    <small class="text-info">FHT</small><br>
                                                                                    <input type="text" class="form-control prev_fht"  style="width: 100%;" disabled>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Other Physical Examination</small><br>
                                                                                <textarea class="form-control prev_other_exam" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Assessment/Diagnosis</small><br>
                                                                                <textarea class="form-control prev_assestment_diagnosis" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <small class="text-info">Plan/Intervention</small><br>
                                                                                <textarea class="form-control prev_plan_intervention" style="resize: none;width: 100%;" disabled> </textarea>
                                                                                </div>
                                                                            </div> 
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_severe_nausea" stlye="float:left" disabled>Severe nausea and vomiting </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_significant_decline" stlye="float:left" disabled>Significant decline fetal movement (less than 10 in 12 hrs during 2 ½ of pregnancy) </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_persistent_contractions" stlye="float:left" disabled>Persistent contractions</td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_premature_rupture" stlye="float:left" disabled>Premature rupture of the bag of membrane </td>
                                                                 
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_multi_pregnancy" stlye="float:left" disabled>Multi fetal pregnancy </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox"  class="prev_persistent_severe" stlye="float:left" disabled>Persistent severe headache, dizziness, or blurring of vision </td>
                                                                    
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_abdominal_pain" stlye="float:left" disabled>Abdominal pain or epigastric pain </td>
                                                                
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_edema_hands" stlye="float:left" disabled>Edema of the hands, feet or face </td>
                                                                  
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box"> 
                                                                    <td ><input type="checkbox" class="prev_fever_pallor" stlye="float:left" disabled>Fever or pallor </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_seiszure_consciousness" stlye="float:left" disabled>Seizure or loss of consciousness </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_difficulty_breathing" stlye="float:left" disabled>Difficulty of breathing </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_painful_urination" stlye="float:left" disabled>Painful urination </td>
                                                                   
                                                                </tr>
                                                                <tr class="sign_symthoms_table_box">
                                                                    <td ><input type="checkbox" class="prev_elevated_bp" stlye="float:left" disabled>Elevated blood pressure ≥ 120/90 </td>
                                                                    
                                                                </tr>
                                                        </table>
                                                    </div> -->
                                    </div>
                                 
                            </div>

                            <div id="lab2" class="tab-pane fade">
                                <button class="btn btn-info btn-flat return_btn_add_lab"><i class="fa fa-plus"></i> Add Row</button>
                                <button class="btn btn-danger btn-flat return_btn_delete_lab"><i class="fa fa-minus"></i> Delete</button>
                                    <table class="table table-striped pre_pregnancy_table" id="return_table_lab_res">
                                        <tr class="bg-gray">
                                            <th>Date of Lab.</th>
                                            <th>CBC Result</th>
                                            <th>UA Result</th>
                                            <th>UTZ</th>
                                            <th>Management/Intervention</th>
                                        </tr>
                                        <tr>
                                            <td> 
                                                <input type="text" class="form-control date_of_lab" placeholder="mm/dd/yyyy" name="date_of_lab[]"></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Hgb: <input type="text" class="form-control" name="cbc_hgb[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        WBC: <input type="text" class="form-control" name="cbc_wbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="cbc_rbc[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Platelet: <input type="text" class="form-control" name="cbc_platelet[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Hct: <input type="text" class="form-control" name="cbc_hct[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Pus: <input type="text" class="form-control" name="ua_pus[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="ua_rbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    <br>
                                                        Sugar: <input type="text" class="form-control" name="ua_sugar[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Specific Gravity: <input type="text" class="form-control" name="ua_gravity[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Albumin: <input type="text" class="form-control" name="ua_albumin[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <textarea name="utz[]" class="form-control"></textarea> </td>

                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <!-- <tr>
                                           <td> <input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Hgb: <input type="text" class="form-control" name="cbc_hgb[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        WBC: <input type="text" class="form-control" name="cbc_wbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="cbc_rbc[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Platelet: <input type="text" class="form-control" name="cbc_platelet[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Hct: <input type="text" class="form-control" name="cbc_hct[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Pus: <input type="text" class="form-control" name="ua_pus[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        RBC: <input type="text" class="form-control" name="ua_rbc[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Sugar: <input type="text" class="form-control" name="ua_sugar[]"> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        Specific Gravity: <input type="text" class="form-control" name="ua_gravity[]">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Albumin: <input type="text" class="form-control" name="ua_albumin[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <textarea name="utz[]" class="form-control"></textarea> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td><input type="text" class="form-control" name="cbc_result[]"> </td>
                                            <td><input type="text" class="form-control" name="ua_result[]"> </td>
                                            <td><input type="text" class="form-control" name="utz[]"> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td><input type="text" class="form-control" name="cbc_result[]"> </td>
                                            <td><input type="text" class="form-control" name="ua_result[]"> </td>
                                            <td><input type="text" class="form-control" name="utz[]"> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="date" class="form-control" name="date_of_lab[]"></td>
                                            <td><input type="text" class="form-control" name="cbc_result[]"> </td>
                                            <td><input type="text" class="form-control" name="ua_result[]"> </td>
                                            <td><input type="text" class="form-control" name="utz[]"> </td>
                                            <td><textarea name="lab_remarks[]" class="form-control"></textarea> </td>
                                        </tr> -->
                                    </table>
                            </div>

                        </div>
                        
                    </div>

                <div class="form-fotter pull-right">
                    <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Back</button>
                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-send"></i> Send</button>
                </div>
                <div class="clearfix"></div>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

