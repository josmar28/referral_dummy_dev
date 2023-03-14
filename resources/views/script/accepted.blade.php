<script>
    <?php $user = Session::get('auth'); ?>

    var arriveRef = dbRef.ref('Arrival');
    var admitRef = dbRef.ref('Admit');
    var dischargetRef = dbRef.ref('Discharge');
    var transferRef = dbRef.ref('Transfer');
    var referred_name = '';
    //initializes variables
    var current_facility, code, patient_name, track_id, form_type;
    current_facility = "{{ \App\Facility::find($user->facility_id)->name }}";

    $('body').on('click','.btn-action',function(){
        code = $(this).data('code');
        patient_name = $(this).data('patient_name');
        track_id = $(this).data('track_id');
    });

    $('#deadForm').on('submit',function(e){
        $('.loading').show();
         e.preventDefault();
         var remarks = $(this).find('.remarks').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/dead/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                var dead_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility,
                    remarks: remarks
                };
                $('.activity_'+code).html('DEAD ON ARRIVAL');
                arriveRef.push(dead_data);
                arriveRef.on('child_added',function(data){
                    setTimeout(function(){
                        arriveRef.child(data.key).remove();
                        var msg = 'Patient is dead on arrival';
                        $('.info').removeClass('hide').find('.message').html(msg);
                        $('#DoAModal').modal('hide');
                        window.location.reload(true);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });

    $('#arriveForm').on('submit',function(e){
        $('.loading').show();
         e.preventDefault();
         var remarks = $(this).find('.remarks').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/arrive/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                var arrive_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility,
                    remarks: remarks
                };
                $('.activity_'+code).html('ARRIVED');
                arriveRef.push(arrive_data);
                arriveRef.on('child_added',function(data){
                    setTimeout(function(){
                        arriveRef.child(data.key).remove();
                        var msg = 'Patient arrived to your facility';
                        $('.info').removeClass('hide').find('.message').html(msg);
                        $('#arriveModal').modal('hide');
                        window.location.reload(true);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });

    $('#archiveForm').on('submit',function(e){
        $('.loading').show();
         e.preventDefault();
         var remarks = $(this).find('.remarks').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/archive/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                var arrive_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility,
                    remarks: remarks
                };
                $('.activity_'+code).html('ARCHIVED');
                arriveRef.push(arrive_data);
                arriveRef.on('child_added',function(data){
                    setTimeout(function(){
                        arriveRef.child(data.key).remove();
                        var msg = 'Patient archived';
                        $('.info').removeClass('hide').find('.message').html(msg);
                        $('#arriveModal').modal('hide');
                        window.location.reload(true);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });

    $('#admitForm').on('submit',function(e){
        $('.loading').show();
        e.preventDefault();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/admit/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                $('.activity_'+code).html('ADMITTED');
                var arrive_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility
                };
                admitRef.push(arrive_data);
                admitRef.on('child_added',function(data){
                    setTimeout(function(){
                        admitRef.child(data.key).remove();
                        var msg = 'Patient admitted to your facility';
                        $('.info').removeClass('hide').find('.message').html(msg);
                        $('#admitModal').modal('hide');
                        window.location.reload(true);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });


    $('#dischargeForm').on('submit',function(e){
        $('.loading').show();
        e.preventDefault();
        var remarks = $(this).find('.remarks').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/discharge/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                var msg = 'Patient admitted to your facility';
                $('.info').removeClass('hide').find('.message').html(msg);
                $('.activity_'+code).html('DISCHARGED');
                var arrive_data = {
                    code: code,
                    patient_name: patient_name,
                    track_id: track_id,
                    date: date,
                    current_facility: current_facility,
                    remarks: remarks
                };
                dischargetRef.push(arrive_data);
                dischargetRef.on('child_added',function(data){
                    setTimeout(function(){
                        dischargetRef.child(data.key).remove();
                        window.location.reload(false);
                    },500);
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });



    $('body').on('click','.btn-transfer',function(){
        $('.loading').hide();
    });

    $('.select_facility').on('change',function(){
        var id = $(this).val();
        var url = "{{ url('location/facility/') }}";
        $.ajax({
            url: url+'/'+id,
            type: 'GET',
            success: function(data){
                console.log(data);
                $('.facility_address').html(data.address);

                $('.select_department').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select Department...'
                    }));
                jQuery.each(data.departments, function(i,val){
                    $('.select_department').append($('<option>', {
                        value: val.id,
                        text : val.description
                    }));
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });

    });

    $('body').on('submit','#referAcceptForm',function(e){
        $('.loading').show();
        e.preventDefault();
        referred_to = $('#referAcceptForm').find('.new_facility').val();
        var new_facility = $('#referAcceptForm').find('.new_facility').find(':selected').html();
        var referred_to = $('#referAcceptForm').find('.new_facility').val();
        var department_name = $('.select_department_accept :selected').text();
        var department_id = $('.select_department_accept').val();
        var reason = $('#referAcceptForm').find('.reject_reason').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/transfer/') }}/"+track_id,
            type: 'POST',
            success: function(data){
                console.log(data);
                transferRef.push({
                    date: data.date,
                    item: track_id,
                    new_facility: new_facility,
                    old_facility: current_facility,
                    action_md: data.action_md,
                    patient_name: patient_name,
                    code: code,
                    reason: reason,
                    activity_id: data.activity_id
                });

                transferRef.on('child_added',function(d){
                    setTimeout(function(){
                        transferRef.child(d.key).remove();
                    },500);
                });

                var connRef = dbRef.ref('Referral');
                var refer_data = {
                    referring_name: current_facility,
                    patient_code: code,
                    name: patient_name,
                    age: data.age,
                    sex: data.sex,
                    date: data.date,
                    form_type: data.form_type,
                    tracking_id: data.track_id,
                    referring_md: data.action_md,
                    referred_from: data.referred_facility,
                    department_id: department_id,
                    department_name: department_name,
                    activity_id: data.activity_id
                };
                console.log(refer_data);
                connRef.child(referred_to).push(refer_data);

                connRef.on('child_added',function(data){
                    setTimeout(function(){
                        connRef.child(data.key).remove();
                        window.location.reload(false);
                    },500);
                });

                var data = {
                    "to": "/topics/ReferralSystem"+referred_to,
                    "data": {
                        "subject": "New Referral",
                        "date": data.date,
                        "body": patient_name+" was transferred to your facility from "+current_facility+"!"
                    }
                };
                $.ajax({
                    url: 'https://fcm.googleapis.com/fcm/send',
                    type: 'post',
                    data: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'key=AAAAJjRh3xQ:APA91bFJ3YMPNZZkuGMZq8MU8IKCMwF2PpuwmQHnUi84y9bKiozphvLFiWXa5I8T-lP4aHVup0Ch83PIxx8XwdkUZnyY-LutEUGvzk2mu_YWPar8PmPXYlftZnsJCazvpma3y5BI7QHP'
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.info(data);
                    }
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });

    $('.view_form').on('click',function(){
        $('.loading').show();
        code = $(this).data('code');
        form_type = $(this).data('type');
        id = $(this).data('id');

        $('#normalFormModal').find('span').html('');
        $('#pregnantFormModal').find('span').html('');

        if(form_type=='normal'){
            getNormalForm();
        }else{
              // getPregnantForm();
              getPregnantFormv2();
        }
    });

    function getPregnantFormv2()
{
    $.ajax({
        url: "{{ url('doctor/referral/data/pregnantv2') }}/"+id,
        type: "GET",
        success: function(data){
            console.log(data);
            $('.button_option').hide();
                
           
                var form = data.form;
                var antepartum = data.antepartum;
                var sign_symptoms = data.sign_symptoms;
                var lab_result  = data.lab_result;
                var preg_vs = data.preg_vs;
                var preg_outcome = data.preg_outcome;
                var patient_address='';

                patient_address += (form.patient_brgy) ? form.patient_brgy+', ': '';
                patient_address += (form.patient_muncity) ? form.patient_muncity+', ': '';
                patient_address += (form.patient_province) ? form.patient_province: '';

                patient_id = form.id;
                name = form.woman_name;
                sex = form.sex;
                age = form.woman_age;
                civil_status = form.woman_status;
                phic_status = form.phic_status;
                phic_id = form.phic_id;
                address = form.address;
                contact = form.contact;
                dob = form.bday;
                religion = form.religion;
                ethnicity = form.ethnicity;
                sibling_rank = form.sibling_rank;
                out_of = form.out_of;
                educ_attainment = form.educ_attainment;
                family_income = form.family_income;

                $("input[name='gravidity']").val(form.gravidity);
                $("input[name='parity']").val(form.parity);
                $("input[name='ftpal']").val(form.ftpal);
                $("input[name='bmi']").val(form.bmi);
                $("input[name='fundic_height']").val(form.fundic_height);
                $("input[name='hr']").val(form.hr);

                $("input[name='lmp']").val(form.lmp);
                $("input[name='edc_edd']").val(form.edc_edd);
                $("input[name='height']").val(form.height);
                $("input[name='weigth']").val(form.weigth);
                $("input[name='bp']").val(form.bp);
                $("input[name='temp']").val(form.temp);

                $("input[name='rr']").val(form.rr);
                $("input[name='td1']").val(form.td1);
                $("input[name='td2']").val(form.td2);
                $("input[name='td3']").val(form.td3);
                $("input[name='td4']").val(form.td4);
                $("input[name='td5']").val(form.td5);

                $('.religion').val(religion);   
                $('.ethnicity').val(ethnicity);   
                $('.sibling_rank').val(sibling_rank);   
                $('.out_of').val(out_of);   

                $('.educ_attainment').val(educ_attainment);   
                $('.family_income').val(family_income);   
                
                $('.phic_id').html(phic_id);    
                $('.civil_status').val(civil_status);    
                $('.preg_civil_status').html(civil_status);
                
                $('.patient_id').val(patient_id);
                $('.patient_name').html(name);
                $('.patient_address').html(patient_address);
                $('.patient_sex').val(sex);
                $('.preg_patient_sex').html(sex);
                
                $('.patient_dob').html($.datepicker.formatDate('M dd,  yy', new Date(dob)));
                $('.patient_age').html(age);
                $('.patient_contact').html(contact);


                $(".prev_trimester").val(sign_symptoms.no_trimester);
                $(".prev_visit").val(sign_symptoms.no_visit);

                $(".new_visit_no").val(sign_symptoms.new_visit_no);
            
                $('.prev_date').val(sign_symptoms.date_of_visit);
                
                if(sign_symptoms !=null)
                {
                    if(sign_symptoms.vaginal_spotting == 'yes')
                    {
                        $('.prev_viganal_bleeding').prop('checked', true);
                    }

                    if(sign_symptoms.severe_nausea == 'yes')
                    {
                        $('.prev_severe_nausea').prop('checked', true);
                    }

                    if(sign_symptoms.significant_decline == 'yes')
                    {
                        $('.prev_significant_decline').prop('checked', true);
                    }

                    if(sign_symptoms.premature_rupture == 'yes')
                    {
                        $('.prev_premature_rupture').prop('checked', true);
                    }

                    if(sign_symptoms.fetal_pregnancy == 'yes')
                    {
                        $('.prev_multi_pregnancy').prop('checked', true);
                    }

                    if(sign_symptoms.severe_headache == 'yes')
                    {
                        $('.prev_persistent_severe').prop('checked', true);
                    }

                    if(sign_symptoms.abdominal_pain == 'yes')
                    {
                        $('.prev_abdominal_pain').prop('checked', true);
                    }

                    if(sign_symptoms.edema_hands == 'yes')
                    {
                        $('.prev_edema_hands').prop('checked', true);
                    }

                    if(sign_symptoms.fever_pallor == 'yes')
                    {
                        $('.prev_fever_pallor').prop('checked', true);
                    }

                    if(sign_symptoms.seizure_consciousness == 'yes')
                    {
                        $('.prev_seiszure_consciousness').prop('checked', true);
                    }

                    if(sign_symptoms.difficulty_breathing == 'yes')
                    {
                        $('.prev_difficulty_breathing').prop('checked', true);
                    }

                    if(sign_symptoms.painful_urination == 'yes')
                    {
                        $('.prev_painful_urination').prop('checked', true);
                    }

                    if(sign_symptoms.elevated_bp == 'yes')
                    {
                        $('.prev_elevated_bp').prop('checked', true);
                    }
                }

                $('.prev_subjective').val(sign_symptoms.subjective); 

                $('.prev_aog').val(sign_symptoms.aog);

                $('.prev_bp').val(sign_symptoms.bp);
                $('.prev_hr').val(sign_symptoms.hr);
                $('.prev_fh').val(sign_symptoms.fh);

                $('.prev_temp').val(sign_symptoms.temp);
                $('.prev_rr').val(sign_symptoms.rr);
                $('.prev_fht').val(sign_symptoms.fht);

                $('.prev_other_exam').val(sign_symptoms.other_physical_exam);
                $('.prev_assestment_diagnosis').val(sign_symptoms.assessment_diagnosis);
                $('.prev_plan_intervention').val(sign_symptoms.plan_intervention);


                if(antepartum !=null)
                {
                    if(antepartum.hypertension == 'yes')
                    {
                        $('.hypertension').prop('checked', true);
                    }

                    if(antepartum.anemia == 'yes')
                    {
                        $('.anemia').prop('checked', true);
                    }

                    if(antepartum.malaria == 'yes')
                    {
                        $('.malaria').prop('checked', true);
                    }

                    if(antepartum.cancer == 'yes')
                    {
                        $('.cancer').prop('checked', true);
                    }

                    if(antepartum.allergies == 'yes')
                    {
                        $('.allergies').prop('checked', true);
                    }

                    if(antepartum.renal_disease == 'yes')
                    {
                        $('.renal_disease').prop('checked', true);
                    }

                    if(antepartum.typhoid_disorders == 'yes')
                    {
                        $('.typhoid_disorders').prop('checked', true);
                    }

                    if(antepartum.hypo_hyper == 'yes')
                    {
                        $('.hypo_hyperthyroidism').prop('checked', true);
                    }

                    if(antepartum.tuberculosis == 'yes')
                    {
                        $('.tuberculosis').prop('checked', true);
                    }

                    if(antepartum.diabetes_mellitus == 'yes')
                    {
                        $('.diabetes_mellitus').prop('checked', true);
                    }

                    if(antepartum.hepatatis_b == 'yes')
                    {
                        $('.hepatitisb_infection').prop('checked', true);
                    }

                    if(antepartum.hiv_sti == 'yes')
                    {
                        $('.hiv_sti').prop('checked', true);
                    }

                    if(antepartum.seizure_disorder == 'yes')
                    {
                        $('.seizure_disorder').prop('checked', true);
                    }

                    if(antepartum.cardiovascular_disease == 'yes')
                    {
                        $('.cadiovascular_disease').prop('checked', true);
                    }

                    if(antepartum.malnutrition == 'yes')
                    {
                        $('.malnutrition').prop('checked', true);
                    }

                    if(antepartum.hemotilgic_disorder == 'yes')
                    {
                        $('.hemotilgic_bleeding').prop('checked', true);
                    }

                    if(antepartum.substance_abuse == 'yes')
                    {
                        $('.alcohol_abuse').prop('checked', true);
                    }

                    if(antepartum.anti_phospholipid == 'yes')
                    {
                        $('.phospholipid_syndrome').prop('checked', true);
                    }

                    if(antepartum.restrictive_pulmonary == 'yes')
                    {
                        $('.asthma').prop('checked', true);
                    }

                    if(antepartum.mental_retardation == 'yes')
                    {
                        $('.psychiatric_mental').prop('checked', true);
                    }

                    if(antepartum.habitual_abortion == 'yes')
                    {
                        $('.habitual_abortion').prop('checked', true);
                    }

                    if(antepartum.fetus_congenital == 'yes')
                    {
                        $('.fetus_congenital').prop('checked', true);
                    }

                    if(antepartum.previous_caesarean == 'yes')
                    {
                        $('.caesarean_section').prop('checked', true);
                    }

                    if(antepartum.preterm_delivery == 'yes')
                    {
                        $('.neonatal_death').prop('checked', true);
                    }
                }

                $('.ante_subjective').val(antepartum.subjective);

                $('.ante_bp').val(antepartum.bp);
                $('.ante_hr').val(antepartum.hr);
                $('.ante_fh').val(antepartum.fh);

                $('.ante_temp').val(antepartum.temp);
                $('.ante_rr').val(antepartum.rr);
                $('.ante_fht').val(antepartum.fht);

                $('.ante_other_physical_exam').val(antepartum.other_physical_exam);
                $('.ante_assessment_diagnosis').val(antepartum.assessment_diagnosis);
                $('.ante_plan_intervention').val(antepartum.plan_intervention);

                $('.bp_15').val(preg_vs.bp_15);
                $('.bp_30').val(preg_vs.bp_30);
                $('.bp_45').val(preg_vs.bp_45);
                $('.bp_60').val(preg_vs.bp_60);
                $('.bp_remarks').val(preg_vs.bp_remarks);

                $('.temp_15').val(preg_vs.temp_15);
                $('.temp_30').val(preg_vs.temp_30);
                $('.temp_45').val(preg_vs.temp_45);
                $('.temp_60').val(preg_vs.temp_60);
                $('.temp_remaks').val(preg_vs.temp_remaks);

                $('.hr_15').val(preg_vs.hr_15);
                $('.hr_30').val(preg_vs.hr_30);
                $('.hr_45').val(preg_vs.hr_45);
                $('.hr_60').val(preg_vs.hr_60);
                $('.hr_remarks').val(preg_vs.hr_remarks);

                $('.rr_15').val(preg_vs.rr_15);
                $('.rr_30').val(preg_vs.rr_30);
                $('.rr_45').val(preg_vs.rr_45);
                $('.rr_60').val(preg_vs.rr_60);
                $('.rr_remarks').val(preg_vs.rr_remarks);

                $('.o2sat_15').val(preg_vs.o2sat_15);
                $('.o2sat_30').val(preg_vs.o2sat_30);
                $('.o2sat_45').val(preg_vs.o2sat_45);
                $('.o2sat_60').val(preg_vs.o2sat_60);
                $('.o2sat_remaks').val(preg_vs.o2sat_remaks);

                $('.fht_15').val(preg_vs.fht_15);
                $('.fht_30').val(preg_vs.fht_30);
                $('.fht_45').val(preg_vs.fht_45);
                $('.fht_60').val(preg_vs.fht_60);
                $('.fht_remarks').val(preg_vs.fht_remarks);

                

                    // $.each( lab_result, function( key, value ) {
                    
                    // var index = key + 1;
                    // console.log(lab_result[1].date_of_lab);
                    //     if(key > 0){
                    //         var markup = '<tr><td><input type="date" class="form-control" value="" name="date_of_lab[]"></td><td><input type="text" class="form-control" name="cbc_result[]"> </td><td><input type="text" class="form-control" name="ua_result[]"> </td><td><input type="text" class="form-control" name="utz[]"> </td><td><textarea name="lab_remarks[]" class="form-control"></textarea> </td></tr>';
                    //     $('#table_lab_res tr:last').after(markup);
                    //     }
                    // });

                    for (let i = 1; i < lab_result.length; i++) 
                    {
                        $('.date_of_lab').val(lab_result[0].date_of_lab);
                        $('.cbc_result').val(lab_result[0].cbc_result);
                        $('.ua_result').val(lab_result[0].ua_result);
                        $('.utz').val(lab_result[0].utz);
                        $('.blood_type').val(lab_result[0].blood_type);
                        $('.hbsag_result').val(lab_result[0].hbsag_result);
                        $('.vdrl_result').val(lab_result[0].vdrl_result);
                        $('.lab_remarks').val(lab_result[0].lab_remarks);

                        console.log(lab_result[i].date_of_lab);
                        var markup = '<tr><td><input type="date" class="form-control" value="' + lab_result[i].date_of_lab + '" name="date_of_lab[]" disabled></td><td><input type="text" value="' + lab_result[i].cbc_result + '" class="form-control" name="cbc_result[]" disabled> </td><td><input type="text" value="' + lab_result[i].ua_result + '" class="form-control" name="ua_result[]" disabled> </td><td><input type="text" value="' + lab_result[i].utz + '" class="form-control" name="utz[]" disabled> </td><td><textarea name="lab_remarks[]" class="form-control" disabled> ' + lab_result[i].lab_remarks + ' </textarea> </td></tr>';
                        $('#table_lab_res_referred tr:last').after(markup);

                        $('#blood_type_referred').attr('rowspan', function(i, rs) { return rs + 1; })
                        $('#hbsag_result_referred').attr('rowspan', function(i, rs) { return rs + 1; })
                        $('#vdrl_result_referred').attr('rowspan', function(i, rs) { return rs + 1; })
                    }

                    if(preg_outcome)
                    {
                        $('.delivery_outcome').val(preg_outcome.delivery_outcome);   
                        $('.birth_attendant').val(preg_outcome.birth_attendant);
                        $('.status_on_discharge').val(preg_outcome.status_on_discharge);   
                        $('.type_of_delivery').val(preg_outcome.type_of_delivery);

                        $('.final_diagnosis').val(preg_outcome.final_diagnosis);
                    }
                    $('.loading').hide();
                   
        },
        error: function(){
            $('#serverModal').modal();
            $('.loading').hide();
        }
    });
}

    function getNormalForm()
    {
        console.log("{{ url('doctor/referral/data/normal') }}/"+id);
        $.ajax({
            url: "{{ url('doctor/referral/data/normal') }}/"+id,
            type: "GET",
            success: function(data){
                var print_url = "{{ url('doctor/print/form/') }}/"+id;
                $('.btn-refer-normal').attr('href',print_url);

                patient_name = data.patient_name;
                referring_name = data.referring_name;

                var address='';
                var patient_address='';
                var referred_address = '';


                address += (data.facility_brgy) ? data.facility_brgy+', ': '';
                address += (data.facility_muncity) ? data.facility_muncity+', ': '';
                address += (data.facility_province) ? data.facility_province: '';

                referred_address += (data.ff_brgy) ? data.ff_brgy+', ': '';
                referred_address += (data.ff_muncity) ? data.ff_muncity+', ': '';
                referred_address += (data.ff_province) ? data.ff_province: '';

                patient_address += (data.patient_brgy) ? data.patient_brgy+', ': '';
                patient_address += (data.patient_muncity) ? data.patient_muncity+', ': '';
                patient_address += (data.patient_province) ? data.patient_province: '';

                var case_summary = data.case_summary;
                if (/\n/g.test(case_summary))
                {
                    case_summary = case_summary.replace(/\n/g, '<br>');
                }

                var reco_summary = data.reco_summary;
                if (/\n/g.test(reco_summary))
                {
                    reco_summary = reco_summary.replace(/\n/g, '<br>');
                }

                var diagnosis = data.diagnosis;
                if (/\n/g.test(diagnosis))
                {
                    diagnosis = diagnosis.replace(/\n/g, '<br>');
                }

                var reason = data.reason;
                if (/\n/g.test(reason))
                {
                    reason = reason.replace(/\n/g, '<br>');
                }


                age = data.age;
                sex = data.sex;
                referring_contact = data.referring_contact;
                referring_md_contact = data.referring_md_contact;
                referred_name = data.referring_name;

                $('span.referring_name').html(data.referring_name);
                $('span.department_name').html(data.department);
                $('span.referring_contact').html(data.referring_contact);
                $('span.referring_address').html(address);
                $('span.referred_name').html(data.referred_name);
                $('span.referred_address').html(referred_address);
                $('span.time_referred').html(data.time_referred);
                $('span.patient_name').html(data.patient_name);
                $('span.patient_age').html(data.age);
                $('span.patient_sex').html(data.sex);
                $('span.patient_status').html(data.civil_status);
                $('span.patient_address').html(patient_address);
                $('span.phic_status').html(data.phic_status);
                $('span.phic_id').html(data.phic_id);
                $('span.case_summary').append(case_summary);
                $('span.reco_summary').html(reco_summary);
                $('span.diagnosis').html(diagnosis);
                $('span.reason').html(reason);
                $('span.referring_md').html(data.md_referring);
                $('span.referring_md_contact').html(data.referring_md_contact);
                $('span.referred_md').html(data.md_referred);
                $('span.patient_bday').html(data.bday);

                $('span.covid_number').html(data.covid_number);
                $('span.clinical_status').html(data.refer_clinical_status);
                $('span.surveillance_category').html(data.refer_sur_category);

                $('.loading').hide();
            },
            error: function(){
                $('#serverModal').modal();
                $('.loading').hide();
            }
        });

    }

    function getPregnantForm()
    {
        $.ajax({
            url: "{{ url('doctor/referral/data/pregnant') }}/"+id,
            type: "GET",
            success: function(record){
                console.log(record);
                var print_url = "{{ url('doctor/print/form/') }}/"+id;
                $('.btn-refer-pregnant').attr('href',print_url);
                $('.button_option').hide();
                var data = record.form;
                var baby = record.baby;
                var patient_address='';
                var referred_address= '';
               


                patient_address += (data.patient_brgy) ? data.patient_brgy+', ': '';
                patient_address += (data.patient_muncity) ? data.patient_muncity+', ': '';
                patient_address += (data.patient_province) ? data.patient_province: '';

                referred_address += (data.ff_brgy) ? data.ff_brgy+', ': '';
                referred_address += (data.ff_muncity) ? data.ff_muncity+', ': '';
                referred_address += (data.ff_province) ? data.ff_province: '';

                var woman_major_findings = data.woman_major_findings;
                if (/\n/g.test(woman_major_findings))
                {
                    woman_major_findings = woman_major_findings.replace(/\n/g, '<br>');
                }

                var woman_information_given = data.woman_information_given;
                if (/\n/g.test(woman_information_given))
                {
                    woman_information_given = woman_information_given.replace(/\n/g, '<br>');
                }

                if(baby){
                    var baby_major_findings = baby.baby_major_findings;
                    if (/\n/g.test(baby_major_findings))
                    {
                        baby_major_findings = baby_major_findings.replace(/\n/g, '<br>');
                    }

                    var baby_information_given = baby.baby_information_given;
                    if (/\n/g.test(baby_information_given))
                    {
                        baby_information_given = baby_information_given.replace(/\n/g, '<br>');
                    }
                }

                age = data.woman_age;
                sex = data.sex;
                referring_contact = data.referring_contact;
                referring_md_contact = data.referring_md_contact;
                referred_name = data.referring_facility;

                $('span.record_no').html(data.record_no);
                $('span.arrival_date').html(data.arrival_date);
                $('span.referred_date').html(data.referred_date);
                $('span.md_referring').html(data.md_referring);
                $('span.referring_md_contact').html(data.referring_md_contact);
                $('span.referring_facility').html(data.referring_facility);
                $('span.department_name').html(data.department);
                $('span.referring_contact').html(data.referring_contact);
                $('span.referred_name').html(data.referred_facility);
                $('span.referred_address').html(referred_address);
                $('span.facility_brgy').html(data.facility_brgy);
                $('span.facility_muncity').html(data.facility_muncity);
                $('span.facility_province').html(data.facility_province);
                $('span.health_worker').html(data.health_worker);
                $('span.woman_name').html(data.woman_name);
                $('span.woman_age').html(data.woman_age);
                $('span.woman_bday').html(data.bday);
                $('span.woman_address').html(patient_address);
                $('span.woman_reason').html(data.woman_reason);
                $('span.woman_major_findings').html(woman_major_findings);
                $('span.woman_before_treatment').html(data.woman_before_treatment);
                $('span.woman_before_given_time').html(data.woman_before_given_time);
                $('span.woman_during_transport').html(data.woman_during_transport);
                $('span.woman_transport_given_time').html(data.woman_transport_given_time);
                $('span.woman_information_given').html(woman_information_given);

                if(baby){

                    $('span.baby_name').html(baby.baby_name);
                    $('span.baby_dob').html(baby.baby_dob);
                    $('span.weight').html(baby.weight);
                    $('span.gestational_age').html(baby.gestational_age);
                    $('span.baby_reason').html(baby.baby_reason);
                    $('span.baby_major_findings').html(baby_major_findings);
                    $('span.baby_last_feed').html(baby.baby_last_feed);
                    $('span.baby_before_treatment').html(baby.baby_before_treatment);
                    $('span.baby_before_given_time').html(baby.baby_before_given_time);
                    $('span.baby_during_transport').html(baby.baby_during_transport);
                    $('span.baby_transport_given_time').html(baby.baby_transport_given_time);
                    $('span.baby_information_given').html(baby_information_given);
                }

                $('span.covid_number').html(data.covid_number);
                $('span.clinical_status').html(data.refer_clinical_status);
                $('span.surveillance_category').html(data.refer_sur_category);

                $('.loading').hide();
            },
            error: function(){
                $('#serverModal').modal();
                $('.loading').hide();
            }
        });
    }

    
    $('.css_btn').on('click',function(){
       var code = $(this).data('code');
        var url = "<?php echo asset('doctor/css'); ?>";
        var json = {
            "code" : code,
            "_token" : "<?php echo csrf_token(); ?>"
        };
        $.post(url,json,function(result){
            $(".css_body").html(result);
        });
       
    });

    @if(Session::get('cssAdd'))
        Lobibox.notify('success', {
            title: "",
            msg: "Successfully Added CSS",
            size: 'mini',
            rounded: true
        });

    <?php
        Session::put("cssAdd",false);
    ?>
    @endif    
</script>